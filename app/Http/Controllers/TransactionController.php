<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionQrcode;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function generateQRCode(Request $request)
    {
        $mode = $request->input('mode');
        $token = $request->input('remember_token');

        // Validate từng biến
        if (empty($mode) || ($mode !== 'deposit' && $mode !== 'payout')) {
            return response()->json([
                'success' => false,
                'status' => 'ignored.',
                'message' => 'ignored.'
            ]);
        }

        if (empty($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Remember token is required.'
            ]);
        }

        $user = User::where('remember_token', $token)->first();
        if (!$user) {
            return response()->json(['success' => false, 'status' => 'error', 'message' => 'Invalid token']);
        }

        // $qrContent = json_encode([
        //     'mode' => $mode,
        //     'remember_token' => $token,
        //     'timestamp' => now()->timestamp, // Thêm dòng này để mỗi lần là 1 mã khác nhau
        // ]);

        // $qrContentEncoded = urlencode($qrContent);
        // $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={$qrContentEncoded}";

        $transaction = TransactionQrcode::create([
            'user_id' => $user->id,
            'mode' => $mode,
            'qr_data' => "",
            'status' => 'pending',
        ]);

        $qrContent = json_encode([
            'transaction_id' => $transaction->id,
            'mode' => $mode,
            'remember_token' => $token,
            'timestamp' => now()->timestamp, // Thêm dòng này để mỗi lần là 1 mã khác nhau
        ]);
        // $data = [
        //     'remember_token' => $token,
        //     'timestamp' => now()->timestamp,
        //     'mode' => $mode,
        // ];
        // $res = json_encode($data);
        return response()->json([
            "qrContent" => $qrContent,
            "success" => true
        ]);
        // return response()->json([
        //     'remember_token' => $token,
        //     'timestamp' => now()->timestamp,
        //     'mode' => $mode,
        // ]);
    }


    public function payout(Request $request)
    {
        $mode = $request->input('mode');
        $token = $request->input('remember_token');
        $transactionId = $request->input('transaction_id');

        // Validate từng biến
        if (empty($mode) || ($mode !== 'deposit' && $mode !== 'payout')) {
            return response()->json([
                'success' => false,
                'status' => 'ignored.',
                'message' => 'ignored.'
            ]);
        }

        if (empty($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Remember token is required.'
            ]);
        }

        if (empty($transactionId)) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction ID is required.'
            ]);
        }

        $user = User::where('remember_token', $token)->first();
        if (!$user) {
            return response()->json(['success' => false, 'status' => 'error', 'message' => 'Invalid token']);
        }

        // Nếu là payout, trừ tiền
        if ($mode === 'payout') {
            // Lấy số tiền cần trả (giả sử lấy từ pending_payout_amount)
            $amount = $user->wallet->balance;

            // Trừ tiền
            $user->wallet->balance -= $amount;
            $user->wallet->save();

            // Cập nhật trạng thái transaction_qrcode nếu cần
            $transaction = TransactionQrcode::where('user_id', $user->id)
                ->where('id', $transactionId)
                ->where('status', 'pending')
                ->latest()
                ->first();
            if ($transaction) {
                $transaction->status = 'completed';
                $transaction->amount = $amount;
                $transaction->save();
            } else {
                return response()->json(['success' => false, 'status' => 'Transaction not found']);
            }

            // Sau khi cập nhật transaction thành công
            // $this->notifyThirdParty('payout_completed', [
            //     'user_id' => $user->id,
            //     'amount' => $amount,
            //     'transaction_id' => $transaction->id,
            //     'time' => now(),
            // ]);

            return response()->json([
                'success' => true,
                'status' => 'ok',
                'message' => 'Payout successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'balance' => $user->wallet->balance,
                ],
                'mode' => $mode,
                'amount' => $amount,
            ]);
        }

        // Nếu là deposit thì chờ bước tiếp theo gửi thêm `amount`
        return response()->json(['success' => true, 'status' => 'ok']);
    }

    public function deposit(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $mode = $request->input('mode');
        $amount = $request->input('amount');
        $token = $request->input('remember_token');

        if (empty($mode) || $mode !== 'deposit') {
            return response()->json([
                'success' => false,
                'status' => 'ignored.',
                'message' => 'Mode must be deposit.'
            ]);
        }

        if (empty($amount)) {
            return response()->json([
                'success' => false,
                'message' => 'Amount is required.'
            ]);
        }

        if (!is_numeric($amount) || !preg_match('/^\d+(\.\d{1,4})?$/', $amount)) {
            return response()->json([
                'success' => false,
                'message' => 'Amount must be a decimal number greater than 0 and max 4 decimals.'
            ]);
        }

        if (empty($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Remember token is required.'
            ]);
        }

        if (empty($transactionId)) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction ID is required.'
            ]);
        }

        $user = User::where('remember_token', $token)->first();
        if (!$user) {
            return response()->json(['success' => false, 'status' => 'error', 'message' => 'Invalid token']);
        }

        $transaction = TransactionQrcode::where('user_id', $user->id)
            ->where('id', $transactionId)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$transaction) {
            return response()->json(['status' => 'error', 'message' => 'Transaction not found']);
        }

        // Ghi nhận tiền nạp
        $user->wallet->balance += $amount;
        $user->wallet->save();

        $transaction->status = 'completed';
        $transaction->amount = $amount;
        $transaction->save();

        return response()->json([
            'success' => true,
            'status' => 'ok',
            'message' => 'Deposit successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'balance' => $user->wallet->balance,
            ],
            'mode' => $mode,
            'amount' => $amount,
        ]);
    }

    public function cancel(Request $request)
    {
        $token = $request->input('remember_token');
        $transactionId = $request->input('transaction_id');
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Remember token is required.'
            ]);
        }

        if (empty($transactionId)) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction ID is required.'
            ]);
        }

        $user = User::where('remember_token', $token)->first();
        if (!$user) {
            return response()->json(['success' => false, 'status' => 'error', 'message' => 'Invalid token']);
        }

        $transaction = TransactionQrcode::where('user_id', $user->id)
            ->where('id', $transactionId)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$transaction) {
            return response()->json(['success' => false, 'status' => 'error', 'message' => 'Transaction not found']);
        }

        $transaction->status = 'cancel';
        $transaction->save();

        return response()->json(['success' => true, 'status' => 'ok', 'message' => 'Transaction cancelled']);
    }

    public function checkTransaction(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $token = $request->input('remember_token');

        if (empty($transactionId)) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction ID is required.'
            ]);
        }

        if (empty($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Remember token is required.'
            ]);
        }

        $user = User::where('remember_token', $token)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token.'
            ]);
        }

        $transaction = TransactionQrcode::where('id', $transactionId)
            ->where('user_id', $user->id)
            ->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found.'
            ]);
        }

        if ($transaction->status === 'pending') {
            return response()->json([
                'success' => false,
                'status' => 'pending',
                'message' => 'Transaction is pending.'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'transaction' => [
                    'id' => $transaction->id,
                    'mode' => $transaction->mode,
                    'amount' => $transaction->amount,
                    'status' => $transaction->status,
                    'credit' => $user->wallet->balance,
                ]
            ]);
        }
        
    }
    protected function notifyThirdParty($event, $data)
    {
        $webhookUrl = 'https://third-party-domain.com/webhook'; // Thay bằng URL thực tế

        try {
            \Illuminate\Support\Facades\Http::post($webhookUrl, [
                'event' => $event,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            // Ghi log nếu cần
            Log::error('Webhook notify failed: ' . $e->getMessage());
        }
    }
}
