<head>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

</head>

<body style="height: 100%; width: 1920px; overflow: hidden;">
    <div id="game-shell" class="game-shell">
        <div id="game-history-container" style="overflow: hidden; visibility: visible; height: 100%; width: 360px; position: relative; z-index: 0;">
            <div id="container-view" style="overflow: hidden;">
                <div style="top: 0%; left: 0px; position: absolute; width: inherit; height: inherit;">
                    <div id="game-list-view" class="game-list-view-container" style="transform: scale(1); background-color: rgb(48, 48, 59);">
                        <div id="game-list-view-wrapper" style="flex-direction: column;">

                            <div style="left: 0%; top: 0px; position: absolute; width: inherit; height: inherit; z-index: 3;">
                                <div id="game-details-view-container" style="background-color: rgb(48, 48, 59); color: rgba(255, 255, 255, 0.6); overflow: hidden; -webkit-font-smoothing: antialiased;">
                                    <div id="game-detail-view-navbar-container" class="" style="height: 62px; padding-top: 0px; background-color: rgb(36, 36, 46);">
                                        <div style="position: absolute; z-index: 4; height: inherit; width: inherit;">
                                            <div id="game-list-nav" style="background-color: rgb(36, 36, 46);">
                                                <div id="game-list-nav-bar" class="game-list-nav-bar-vertical" style="height: calc(100% - 2px);">
                                                    <div class="game-list-nav-image-container game-list-nav-image-container-slot">
                                                        <a href="{{$api_url}}/history?token={{$token}}"> </a>
                                                        <div id="game-list-nav-image-left" class="game-list-nav-image " style="transform: scale(0.7);">
                                                            <div class="gh-arrow " style="transform: translate(0px, 0px); background-color: rgb(224, 111, 54);"></div>
                                                        </div>
                                                    </div>
                                                    <div id="game-list-nav-label-container" class="game-list-nav-label-container-vertical ">
                                                        <div class="game-list-nav-row-container ">
                                                            <div id="game-free-spin-nav-label-wrapper" style="width: 92px;">
                                                                <div id="game-free-spin-nav-label" style="color: rgb(224, 111, 54);">Normal Spin</div>
                                                            </div>
                                                            <div id="nav-drop-down-arrow">
                                                                <div class="gh-angle-wrapper" style="transform: translateY(-4px);">
                                                                    <div id="calendar-arrow" class="gh-angle-horizontal angle-down" style="transition: transform 0.15s ease-out 0s; border-color: rgb(224, 111, 54);"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="game-list-nav-subtitle-label" style="color: rgba(255, 255, 255, 0.4);">2023/11/01 08:40 (GMT+7:00)</div>
                                                    </div>
                                                    <div class="game-list-nav-image-container game-list-nav-image-container-slot">
                                                        <div id="game-list-nav-image-right" class="game-list-nav-image" style="display: none;">
                                                            <div class="exit-icon vertical">
                                                                <div class="exit-icon-stroke exit-icon-stroke-one exit-icon-stroke-vertical" style="background-color: rgba(255, 255, 255, 0.6);"></div>
                                                                <div class="exit-icon-stroke exit-icon-stroke-two exit-icon-stroke-vertical" style="background-color: rgba(255, 255, 255, 0.6);"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="game-list-nav-separator-vertical-slot" style="background-color: rgb(48, 48, 60);"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="game-detail-spring-wrapper" style="position: absolute; height: 578px; transform: translate3d(0px, 0px, 0px);">
                                        <div id="game-details-page-container" style="height: 578px;">
                                            <div id="game-pages-window" style="position: relative;">

                                            </div>
                                        </div>
                                    </div>
                                    <div id="game-details-left-arrow" style="margin-top: 221px; background-color: rgba(0, 0, 0, 0.4);">
                                        <div class="gh-angle-wrapper" style="transform: translateX(4px) scale(0.7);">
                                            <div class="gh-angle-horizontal angle-left" style="border-color: rgb(224, 111, 54);"></div>
                                        </div>
                                    </div>
                                    <div id="game-details-right-arrow" style="margin-top: 221px;margin-left: 317px; background-color: rgba(0, 0, 0, 0.4);">
                                        <div class="gh-angle-wrapper" style="transform: translateX(-4px) scale(0.7);">
                                            <div class="gh-angle-horizontal angle-right" style="border-color: rgb(224, 111, 54);"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const id = '{{$uuid}}';
        const apiUrl = '{{$api_url}}';
        const token = '{{$token}}';
        const gameName = '{{$gameName}}';
        var postData = {
            "action": "history_detail",
            "uuid": id
        };

        $(document).ready(function() {
            var totalSlide = 0;
            var titleArr = [];
            var numberFree = [];
            var totalFreeSpin = 0;
            var spinDate = [];
            var spinHour = [];
            $.ajax({
                type: 'POST',
                url: apiUrl,
                data: JSON.stringify(postData),
                contentType: "application/json",
                async: false,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-Ncash-token', token);
                },
                dataType: 'json',
                success: function(data) {

                    var win = 0;
                    var drop = 0;
                    var rowChild = "";
                    var action = "";
                    var reelSlot = "";
                    var log = data.data;
                    var items = log.res_data;
                    var freeMode = false;
                    var title = "";
                    var betInformation = "";
                    var transactionItem = "";
                    var listPage = "";
                    var slideCss = 0;
                    var countFreeSpin = items.length - 1;
                    var listPageEl = $('#game-pages-window');
                    var betSize = data.data['bet_size'];
                    var betLevel = data.data['bet_level']
                    for (let i = 0; i < items.length; i++) {
                        var item = items[i]['result_json'];
                        var countItem = item.length;
                        var countFreeSpin = item.length - 1;
                        totalFreeSpin = item[countFreeSpin]['total_freespin'];
                        var date = item[countFreeSpin]['spin_date'];
                        var hour = item[countFreeSpin]['spin_hour'];
                        var freeMode = item[countFreeSpin]['free_spin'];
                        var betSize = item[countFreeSpin]['bet_size'];
                        // var credit = item[countFreeSpin]['credit'];
                        var winTotal = item[countFreeSpin]['win_total'];
                        var winMulti = item[countFreeSpin]['win_multi'];
                        var betLevel = item[countFreeSpin]['bet_level'];
                        var titleSpin = freeMode ? "Free Spin" : "Normal Spin";
                        var numberFreeSpin = item[countFreeSpin]['free_num'];
                        var transaction = item[countFreeSpin]['transaction'];
                        var freeNum = item[countFreeSpin]['free_num']
                        var countScatter = item[countFreeSpin]['count_scatter'];
                        var freeSpinMore = item[countFreeSpin]['freespin_more'];
                        var multiply = item[countFreeSpin]['mutilply'];
                        for (let j = 0; j < countItem; j++) {

                            titleArr.push(titleSpin);
                            numberFree.push(i);
                            spinDate.push(date);
                            spinHour.push(hour);
                            totalSlide++;
                            var betAmount = item[countFreeSpin]['bet_amount'];
                            var profit = item[countFreeSpin]['profit'];
                            var resDetail = item[j];
                            var betAmount = j == 0 ? item[countFreeSpin]['bet_amount'] : 0;
                            var countLastReel = item[j]['new_reel'].length - 1;
                            // var profit = j == (countItem - 1) ? item[countFreeSpin]['profit'] : -betAmount;
                            var lastReel = item[j]['new_reel'][countLastReel];
                            var symbolReel = item[j]['new_reel'];
                            var position = item[j]['drop_position'];
                            var winDrop = item[j]['win_drop'];
                            var symbolScatter = "symbol_1";
                            var credit = item[j]['credit_drop']
                            var profit = item[j]['profit'];
                            var betAmount = item[j]['total_bet'];
                            var payout = "";
                            if (winDrop !== 0) {
                                for (let c = 0; c < winDrop.length; c++) {
                                    var symbolWin = winDrop[c];
                                    payout = payout + `
                                <div id="payout-main-view"
                                    style="display: flex; justify-content: space-between; flex-direction: column; align-items: center; width: inherit; margin: auto;">
                                <div style="width: 285px; height: 48px; align-self: start;">
                                        <div class="payoutContainer"
                                            style="display: flex; width: 270px; height: 48px; justify-content: space-between; flex-direction: row; margin-bottom: 0px; margin-right: 0px;">
                                            <div class="payoutImageContainer" style="min-width: 50px; width: 50px; height: inherit; position: relative;">
                                                <span class="${symbolWin['name']} symbol_atlas"
                                                    style="display: block; transform-origin: left top; transform: scale(0.5); margin-left: -10px; margin-top: -10px;"></span>
                                            </div>
                                            <div class="payoutDescContainer"
                                                style="width: 130px; position: relative; flex-direction: column; min-width: 130px; margin-top: 5px;">
                                                <div class="Desc" style="font-size: 12px; color: rgb(255, 255, 255); text-align: left;">${symbolWin['count_column']} of a Kind</div>
                                                <div class="bottomDesc" style="font-size: 10px; color: rgba(255, 255, 255, 0.4);">${symbolWin['ways']} way(s)</div>
                                            </div>
                                            <div class="payoutTextContainer"
                                                style="width: 90px; position: relative; flex-direction: column; min-width: 90px; margin-top: 10px;">
                                                <div class="payoutTitle" style="font-size: 12px; color: rgb(255, 255, 255); text-align: right;">฿${symbolWin['win']}</div>
                                            </div>
                                        </div>
                                        <div class="gh_basic_sprite gh_ic_nav_info_s" tabindex="0" data-descr=""
                                                                                            style="transform: translate(270px, -48.5px) scale(0.3333); opacity: 0.4;">
																							
                                                                                        </div>
                                            <div id="tooltip"
                                                style="position: relative; width: 300px; height: inherit; align-self: center; top: -53px;left:-2px;z-index:1">
                                                <div role="tooltip"
                                                    style="left: 90%; border-width: 6px; border-style: solid; border-color: transparent transparent rgb(70, 70, 83); border-image: initial; height: 0px; width: 0px; position: absolute; pointer-events: none; bottom: 98%;">
                                                </div>
                                                <div id="tooltip-toast"
                                                    style="background-color: rgb(70, 70, 83); color: rgb(255, 255, 255); border-radius: 6px; padding: 5px;">
                                                    <div id="tooltip-title" style="color: rgb(128, 128, 128); font-size: 12px; text-align: left; padding: 0px 8px;">
                                                        Bet Size x Bet Level x Symbol Payout Values x Way(s)
                                                    </div>
                                                    <div id="tooltip-desc" style="font-size: 12px; text-align: left; padding: 0px 8px;">${betSize} x ${betLevel} x ${symbolWin['payout']} x ${symbolWin['ways']}
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>`;
                                }
                            }

                            // payout1 = "";
                            if (!freeMode && winDrop == 0 && freeNum > 0) {
                                payout = `
                                <div class="payoutContainer"
                                    style="display: flex; width: 270px; height: 48px; justify-content: space-between; flex-direction: row; margin-bottom: 0px; margin-right: 18px;">
                                    <div class="payoutImageContainer" style="min-width: 50px; width: 50px; height: inherit; position: relative;"><span
                                            class="${symbolScatter} special_symbol_atlas"
                                            style="display: block; transform-origin: left top; transform: scale(0.5); margin-left: -10px; margin-top: -10px;"></span>
                                    </div>
                                    <div class="payoutDescContainer"
                                        style="width: 130px; position: relative; flex-direction: column; min-width: 130px; margin-top: 10px;">
                                        <div class="Desc" style="font-size: 12px; color: rgb(255, 255, 255); text-align: left;">x ${countScatter}</div>
                                    </div>
                                    <div class="payoutTextContainer"
                                        style="width: 90px; position: relative; flex-direction: column; min-width: 90px; margin-top: 10px;">
                                        <div class="payoutTitle" style="font-size: 12px; color: rgb(255, 255, 255); text-align: right;">${numberFreeSpin} Free Spins
                                        </div>
                                    </div>
                                </div>
                            ` + payout;
                            }

                            if (freeMode && countScatter > 0 && winDrop == 0) {
                                payout = payout + `<div class="payoutContainer"
                                        style="display: flex; width: 270px; height: 48px; justify-content: space-between; flex-direction: row; margin-bottom: 0px; margin-right: 18px;">
                                        <div class="payoutImageContainer" style="min-width: 50px; width: 50px; height: inherit; position: relative;"><span
                                                class="${symbolScatter}_1 symbol_atlas "
                                                style="display: block; transform-origin: left top; transform: scale(0.5); margin-left: -10px; margin-top: -10px;"></span>
                                        </div>
                                        <div class="payoutDescContainer"
                                            style="width: 130px; position: relative; flex-direction: column; min-width: 130px; margin-top: 10px;">
                                            <div class="Desc" style="font-size: 12px; color: rgb(255, 255, 255); text-align: left;">x ${countScatter}</div>
                                        </div>
                                        <div class="payoutTextContainer"
                                            style="width: 90px; position: relative; flex-direction: column; min-width: 90px; margin-top: 10px;">
                                            <div class="payoutTitle" style="font-size: 12px; color: rgb(255, 255, 255); text-align: right;">${freeSpinMore} Free Spin(s)
                                            </div>
                                        </div>
                                    </div>`
                            }
                            if (winDrop == 0) {
                                payout = payout + `
                                    <div class="payoutContainer"
                                        style="display: flex; width: 270px; height: 48px; justify-content: space-between; flex-direction: row; margin-bottom: 0px; margin-right: 18px;">
                                        <div class="payoutDescContainer"
                                            style="width: 0px; position: relative; flex-direction: column; min-width: 0px; margin-top: 10px;"></div>
                                        <div class="payoutTextContainer"
                                            style="width: inherit; position: relative; flex-direction: column; min-width: inherit; margin-top: 10px;">
                                            <div class="payoutTitle" style="font-size: 12px; color: rgb(255, 255, 255); text-align: left;">Win Multiplier x${multiply}
                                            </div>
                                        </div>
                                    </div>                                
                                 `
                                if (winTotal > 0) {
                                    payout = payout + `
                                    <div class="payoutContainer"
                                        style="display: flex; width: 270px; height: 48px; justify-content: space-between; flex-direction: row; margin-bottom: 0px; margin-right: 18px;">
                                        <div class="payoutDescContainer"
                                            style="width: 130px; position: relative; flex-direction: column; min-width: 130px; margin-top: 10px;">
                                            <div class="Desc" style="font-size: 12px; color: rgb(255, 255, 255); text-align: left;">Multiplier Win </div>
                                        </div>
                                        <div class="payoutTextContainer"
                                            style="width: 90px; position: relative; flex-direction: column; min-width: 90px; margin-top: 5px;">
                                            <div class="payoutTitle" style="font-size: 12px; color: rgb(255, 255, 255); text-align: right;">${winMulti}</div>
                                            <div class="payoutText" style="font-size: 10px; color: rgba(255, 255, 255, 0.4); text-align: right;">${winTotal} x ${multiply}
                                            </div>
                                        </div>
                                    </div>
                            
                                `

                                }
                                payout = payout + `<div id="no-winning-combination-container"
                                                style="display: flex; width: inherit; height: 48px; justify-content: center; align-items: center; margin: 0px auto;">
                                                <div id="no-winning-combination-text" style="font-size: 14px; color: rgb(204, 204, 204);">No Winning Combination
                                                </div>
                                            </div>`

                            }

                            // var aa = payout1+payout;
                            payoutTitle = `
                            <div id="payout-title-container"
                                style="display: flex; width: inherit; height: 32px; justify-content: center; align-items: center; margin: 0px auto;">
                                <div class="line" style="width: 120px; background-color: rgb(40, 40, 51); height: 2px;"></div>
                                <div id="payout-text" style="text-align: center; width: 72px; font-size: 11px; color: rgb(156, 155, 155);">Payout
                                </div>
                                <div class="line" style="width: 120px; background-color: rgb(40, 40, 51); height: 2px;"></div>
                            </div>
                        `


                            var slotColumn = "";
                            for (let c = 0; c < countLastReel; c++) {
                                var slotItem = "";
                                for (let d = 0; d < symbolReel[c].length; d++) {
                                    var symbol = symbolReel[c][d];
                                    symbol = freeMode && symbol == "symbol_1" ? symbol + "_1" : symbol;
                                    var imagesSymbol = !freeMode ? "special_symbol_atlas" : "symbol_atlas";

                                    var check = c + d * 6 + 1;
                                    if (position.includes(check)) {
                                        if (symbol == "symbol_1" || symbol == "symbol_0") {
                                            slotItem = slotItem + `
                                                <div id="slot-item" style="width: 50px; height: 50px;"><span
                                                class="${symbol} special_symbol_atlas"
                                                style="display: block; position: absolute; transform-origin: left top; margin-top: -10px; margin-left: -10px; transform: scaleX(0.55) scaleY(0.55); z-index: 1;"></span>
                                                <div id="win-highlight-item"><span class="wh symbol_atlas" style="display: block; position: absolute; transform-origin: left top; margin-top: -10px; margin-left: -10px; transform: scaleX(0.55) scaleY(0.55); z-index: 1;"></span></div>
                                                </div>
                                    
                                            `;
                                        } else {
                                            slotItem = slotItem + `
                                                <div id="slot-item" style="width: 50px; height: 50px;"><span
                                                class="${symbol} symbol_atlas"
                                                style="display: block; position: absolute; transform-origin: left top; margin-top: -10px; margin-left: -10px; transform: scaleX(0.55) scaleY(0.55); z-index: 1;"></span>
                                                <div id="win-highlight-item"><span class="wh symbol_atlas" style="display: block; position: absolute; transform-origin: left top; margin-top: -10px; margin-left: -10px; transform: scaleX(0.55) scaleY(0.55); z-index: 1;"></span></div>
                                                </div>
                                    
                                             `;

                                        }


                                    } else {
                                        if (symbol == "symbol_1" || symbol == "symbol_0") {
                                            slotItem = slotItem + `
                                            <div id="slot-item" style="width: 50px; height: 50px;"><span
                                            class="${symbol} special_symbol_atlas"
                                            style="display: block; position: absolute; transform-origin: left top; margin-top: -10px; margin-left: -10px; transform: scaleX(0.55) scaleY(0.55); z-index: 1;"></span>
                                            </div>
                                        `;
                                        } else {
                                            slotItem = slotItem + `
                                            <div id="slot-item" style="width: 50px; height: 50px;"><span
                                            class="${symbol} symbol_atlas"
                                            style="display: block; position: absolute; transform-origin: left top; margin-top: -10px; margin-left: -10px; transform: scaleX(0.55) scaleY(0.55); z-index: 1;"></span>
                                            </div>
                                        `;
                                        }
                                    }

                                }

                                slotColumn = slotColumn + `
                            <div id="slot-item-column"
                                style="position: relative; min-width: 50px; width: 50px; height: inherit; display: flex; flex-direction: column;">` +
                                    slotItem + `</div>`;
                            }

                            var trainSymbol = "";
                            for (let c = 0; c < lastReel.length; c++) {
                                var checkLastReel = countLastReel * 4 + c + 1;
                                var imagesSymbol = lastReel[c] == "symbol_1" || lastReel[c] == "symbol_0" ? "special_symbol_atlas" : "symbol_atlas";
                                if (position.includes(checkLastReel)) {
                                    trainSymbol = trainSymbol + `
                                    <div id="slot-item-column"
                                                    style="position: relative; min-width: 50px; width: 50px; height: inherit; display: flex; flex-direction: column;">
                                                        <div id="slot-item" style="width: 50px; height: 50px;"><span
                                                            class="${lastReel[c]} ${imagesSymbol}"
                                                            style="display: block; position: absolute; transform-origin: left top; margin-top: -10px; margin-left: -10px; transform: scaleX(0.55) scaleY(0.55); z-index: 1;"></span>
                                                            <div id="win-highlight-item"><span class="wh symbol_atlas" style="display: block; position: absolute; transform-origin: left top; margin-top: -10px; margin-left: -10px; transform: scaleX(0.55) scaleY(0.55); z-index: 1;"></span></div> 
                                                    </div>
                                                    
                                                </div>
                                                   
                                    `;
                                } else {
                                    trainSymbol = trainSymbol + `
                                        <div id="slot-item-column"
                                                        style="position: relative; min-width: 50px; width: 50px; height: inherit; display: flex; flex-direction: column;">
                                                            <div id="slot-item" style="width: 50px; height: 50px;"><span
                                                                class="${lastReel[c]} ${imagesSymbol}"
                                                                style="display: block; position: absolute; transform-origin: left top; margin-top: -10px; margin-left: -10px; transform: scaleX(0.55) scaleY(0.55); z-index: 1;"></span>
                                                        </div>
                                                    </div>
                            `;
                                }

                            }






                            transactionItem = `
                                    
                                            <div id="transaction-details-container"
                                                style="display: flex; width: inherit; height: 50px; margin: 0px auto; justify-content: center; align-items: center; background-color: rgb(36, 36, 46);">
                                                <div class="transaction-detail-item"
                                                    style="display: flex; flex-direction: column; align-items: center; width: 27%;">
                                                    <div id="detail-item-holder"
                                                        style="height: 23px; display: flex; justify-content: center; align-items: center;">
                                                        <div id="Transaction-item-value"
                                                            style="text-align: center; display: inline-table; color: rgba(255, 255, 255, 0.6); font-size: 8px; line-height: 12px;">
                                                            ${transaction}</div>
                                                    </div>
                                                    <div id="Transaction-item-key" style="text-align: center; font-size: 11px; color: rgb(224, 111, 54);">
                                                        Transaction</div>
                                                </div>
                                                <div class="transaction-detail-item"
                                                    style="display: flex; flex-direction: column; align-items: center; width: 18%; margin-left: 10px;">
                                                    <div id="detail-item-holder"
                                                        style="height: 23px; display: flex; justify-content: center; align-items: center;">
                                                        <div id="Bet(฿)-item-value"
                                                            style="text-align: center; display: inline-table; color: rgba(255, 255, 255, 0.6); font-size: 11px; line-height: 12px;">
                                                            ${betAmount}</div>
                                                    </div>
                                                    <div id="Bet(฿)-item-key" style="text-align: center; font-size: 11px; color: rgb(224, 111, 54);">Bet(฿)
                                                    </div>
                                                </div>
                                                <div class="transaction-detail-item"
                                                    style="display: flex; flex-direction: column; align-items: center; width: 20%; margin-left: 10px;">
                                                    <div id="detail-item-holder"
                                                        style="height: 23px; display: flex; justify-content: center; align-items: center;">
                                                        <div id="Profit(฿)-item-value"
                                                            style="text-align: center; display: inline-table; color: rgba(255, 255, 255, 0.6); font-size: 11px; line-height: 12px;">
                                                            ${profit}</div>
                                                    </div>
                                                    <div id="Profit(฿)-item-key" style="text-align: center; font-size: 11px; color: rgb(224, 111, 54);">
                                                        Profit(฿)</div>
                                                </div>
                                                <div class="transaction-detail-item"
                                                    style="display: flex; flex-direction: column; align-items: center; width: 27%; margin-left: 10px;">
                                                    <div id="detail-item-holder"
                                                        style="height: 23px; display: flex; justify-content: center; align-items: center;">
                                                        <div id="Balance(฿)-item-value"
                                                            style="text-align: center; display: inline-table; color: rgba(255, 255, 255, 0.6); font-size: 11px; line-height: 12px;">
                                                            ${credit}</div>
                                                    </div>
                                                    <div id="Balance(฿)-item-key" style="text-align: center; font-size: 11px; color: rgb(224, 111, 54);">
                                                        Balance(฿)</div>
                                                </div>
                                            </div>
                                         
                        `;

                            var betInformation = `
                            <div id="bet-information-container"
                                                    style="display: flex; width: inherit; height: 50px; margin: 0px auto 5px; justify-content: center; align-items: center; padding-left: 10px; padding-right: 10px;">
                                                    <div id="bet-size-label"
                                                        style="font-size: 11px; text-align: center; word-break: break-word; color: rgba(255, 255, 255, 0.4);">
                                                        Bet Size ${betSize}</div>
                                                    <div id="separator"
                                                        style="width: 2px; height: 12px; margin-left: 10px; margin-right: 10px; background-color: rgb(40, 40, 51);">
                                                    </div>
                                                    <div id="bet-level-label"
                                                        style="font-size: 11px; text-align: center; word-break: break-word; color: rgba(255, 255, 255, 0.4);">
                                                        Bet Level ${betLevel}</div>
                                                </div>
                        `
                            var page = $(`<div class="game-list-page" style="width: 100%; height: 578px; position: absolute; left: ${slideCss}px;">
                                    <div class="reset">` + transactionItem + ` <div class="history regular" style="width: inherit; height: 528px;">
                                            <div class=" rcs-custom-scroll " style="height: inherit;">
                                                <div class="rcs-outer-container" style="height: 100%;">
                                                    <div class="rcs-positioning">
                                                        <div class="rcs-custom-scrollbar ">
                                                            <div class="rcs-custom-scroll-handle" style="height: 443.218px; top: 0px;">
                                                                <div class="rcs-inner-handle"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="rcs-inner-container" style="height: 100%; margin-right: -17px;">
                                                        <div style="height: 100%; overflow-y: scroll; margin-right: 0px;">
                                                            <div id="bet-details-container" style="display: flex; flex-direction: column;">` + betInformation + `<div id="slot-main-view" style="display: flex; width: 300px; margin: auto;">
                                                                    <div id="bet-results-container"
                                                                        style="display: flex; position: relative; width: 300px; margin: auto auto 10px; flex-direction: column;">
                                                                        <div><span class="history_bg bg_main" id="slot-background"
                                                                                style="display: block; position: absolute; transform-origin: left top; transform: scaleX(0.55) scaleY(0.55); top: -12px; left: -8px; z-index: 0; margin-top: 6px; margin-left: 3px;"></span>
                                                                        </div>
                                                                        <div id="train-symbols-container"
                                                                            style="position: relative; display: flex; justify-content: center; height: inherit; margin-top: 0px;">` + trainSymbol + `
                                                                            </div>
                                                                        <div id="space" style="height: 4px;"></div>
                                                                        <div id="symbols-container"
                                                                            style="position: relative; display: flex; justify-content: center; height: inherit; margin-top: 0px;">` + slotColumn + `
                                                                            </div>
                                                                    </div>
                                                                </div>` + payoutTitle + `<div id="payout-main-view"
                                                                    style="display: flex; justify-content: space-between; flex-direction: column; align-items: center; width: inherit; margin: auto;">
                                                                    <div id="payout-main-view"
                                                                        style="display: flex; justify-content: space-between; flex-direction: column; align-items: center; width: inherit; margin: auto;">
                                                                        </div>` + payout + `
                                                                        </div>
                                                                <div id="tooltip"
                                                                    style="position: relative; width: 300px; height: inherit; align-self: center; visibility: hidden; top: 0px;">
                                                                    <div
                                                                        style="left: 90%; border-width: 6px; border-style: solid; border-color: transparent transparent rgb(70, 70, 83); border-image: initial; height: 0px; width: 0px; position: absolute; pointer-events: none; bottom: 98%;">
                                                                    </div>
                                                                    <div id="tooltip-toast"
                                                                        style="background-color: rgb(70, 70, 83); color: rgb(255, 255, 255); border-radius: 6px; padding: 5px;">
                                                                        <div id="tooltip-title"
                                                                            style="color: rgb(128, 128, 128); font-size: 12px; text-align: left; padding: 0px 8px;">
                                                                        </div>
                                                                        <div id="tooltip-desc"
                                                                            style="font-size: 12px; text-align: left; padding: 0px 8px;"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="game-detail-padding" style="width: inherit; height: 86px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);

                            slideCss = slideCss + 360;
                            listPageEl.append(page);
                            // listPage = listPage + page;
                        }


                        //     title = (`
                        //                                 <div id="game-list-nav-label-container" class="game-list-nav-label-container-vertical ">
                        //                                     <div class="game-list-nav-row-container ">
                        //                                         <div id="game-free-spin-nav-label-wrapper" style="width: 84px;">
                        //                                             <div id="game-free-spin-nav-label" style="color: rgb(224, 111, 54);">${titleSpin}</div>
                        //                                         </div>
                        //                                         <div id="nav-drop-down-arrow">
                        //                                             <div class="gh-angle-wrapper" style="transform: translateY(-4px);">
                        //                                                 <div id="calendar-arrow" class="gh-angle-horizontal angle-down"
                        //                                                     style="transition: transform 0.15s ease-out 0s; border-color: rgb(224, 111, 54);">
                        //                                                 </div>
                        //                                             </div>
                        //                                         </div>
                        //                                     </div>
                        //                                     <div class="game-list-nav-subtitle-label" style="color: rgba(255, 255, 255, 0.4);">${spinDate} ${spinHour}
                        //                                         (GMT+7:00)</div>
                        //                                 </div>

                        // `);




                    }


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }


            });

            var currSlideIndex = 0;
            var currSlideCss = 0;
            var translate = 360;
            var slideNext = function() {
                currSlideCss = currSlideCss - translate;
                currSlideIndex++

                $('#game-detail-spring-wrapper').css("transform", "translate3d(" + currSlideCss + "px,0px,0px)");
                if (titleArr[currSlideIndex] == "Normal Spin") {
                    $("#game-free-spin-nav-label").text(titleArr[currSlideIndex]);
                } else {
                    $("#game-free-spin-nav-label").text(titleArr[currSlideIndex] + ":" + numberFree[currSlideIndex] + "/" + totalFreeSpin);
                }

                $(".game-list-nav-subtitle-label").text(spinDate[currSlideIndex] + " " + spinHour[currSlideIndex])
                checkButton();
            }
            var slideBack = function() {
                currSlideCss = currSlideCss + translate;
                currSlideIndex--;
                $('#game-detail-spring-wrapper').css("transform", "translate3d(" + currSlideCss + "px,0px,0px)");
                if (titleArr[currSlideIndex] == "Normal Spin") {
                    $("#game-free-spin-nav-label").text(titleArr[currSlideIndex]);
                } else {
                    $("#game-free-spin-nav-label").text(titleArr[currSlideIndex] + ":" + numberFree[currSlideIndex] + "/" + totalFreeSpin);
                }
                $(".game-list-nav-subtitle-label").text(spinDate[currSlideIndex] + " " + spinHour[currSlideIndex])
                checkButton();
            }

            var a = 0;
            var checkButton = function() {
                if (currSlideIndex == 0) {
                    $("#game-details-left-arrow").hide()
                    $("#game-details-right-arrow").show()
                } else if (currSlideIndex == totalSlide - 1) {
                    $("#game-details-left-arrow").show()
                    $("#game-details-right-arrow").hide()
                } else {
                    $("#game-details-left-arrow").show()
                    $("#game-details-right-arrow").show()
                }
            }
            $('#game-details-right-arrow').click(function() {
                slideNext();
            });


            if (totalSlide - 1 == 0) {
                $("#game-details-left-arrow").hide()
                $("#game-details-right-arrow").hide()
            } else {
                checkButton();
            }
            // transform: translate3d(0px, 0px, 0px);">
            $('#game-details-left-arrow').click(function() {
                slideBack();
            });

            $(".game-list-nav-image-container-slot").click(function() {
                var href = apiUrl + "/info?action=histories&token=" + token;
                window.location.href = href
            });

        });
        window.addEventListener('message', event => {
            console.log(event.data)
            var scale = event.data.scale;
            document.documentElement.style
                .setProperty('--construct-scale', scale);
        });
        const data = {
            "action": "load_scale"
        }
        // window.parent.C3.Plugins.TegaGame_slotgen_api_connect.Acts.CloseHistories();
        window.parent.postMessage(
            // 👇️ data you want to pass to the other page
            data,
            // 👇️ no preference about the origin of the destination
            '*',
        );
    </script>
</body>

<style>
    [id=tooltip] {
        visibility: hidden;
    }

    div[data-descr]:focus+[id="tooltip"] {
        visibility: visible;
    }

    #game-shell {
        transform: scale(calc(var(--construct-scale) *2.1));
        transform-origin: left top;
    }

    #game-shell {
        display: flex;
        height: 750px;
        position: fixed;
        margin-top: -9px;
        margin-left: -7px;
    }

    #game-overlay {
        height: 100%;
        position: absolute;
        width: 0
    }

    #background-img {
        background-size: cover;
        bottom: -10%;
        height: 110%;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: 100%
    }

    #block-page,
    #scroll-area {
        height: 100%;
        position: absolute;
        width: 100%
    }

    #block-page {
        left: 0;
        margin: auto;
        top: 0
    }

    div {
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        display: block;
        outline: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none
    }

    input::-webkit-inner-spin-button,
    input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0
    }

    video {
        height: 100%;
        width: 100%
    }



    a:active,
    a:hover,
    a:link,
    a:visited {
        color: #666
    }

    p.header {
        font-size: small
    }

    p.footer {
        font-size: x-small
    }

    .game-shell {
        font-family: PingFang SC, Microsoft YaHei, WenQuanYi Micro Hei, sans-serif;
        touch-action: none
    }

    .screen_compat {
        height: auto;
        margin: auto;
        max-height: 780px;
        min-height: 640px;
        position: absolute;
        width: 360px
    }

    .screen_compat_land {
        height: 360px;
        margin: auto;
        max-width: 780px;
        min-width: 640px;
        position: absolute;
        width: auto
    }

    .screen_safe_area {
        height: 640px;
        width: 360px;
        z-index: 0
    }

    .screen_safe_area,
    .screen_safe_area_land {
        bottom: 0;
        left: 0;
        margin: auto;
        position: absolute;
        right: 0;
        top: 0
    }

    .screen_safe_area_land {
        height: 360px;
        width: 640px
    }

    .background_ios11 {
        height: 100vmax;
        position: absolute
    }

    .screen_color {
        background-color: #000
    }

    .lobby .screen_color {
        background-color: #fff
    }

    #splash {
        background-image: url({{$gamePublicFolder}}/28f6cc13-65b3-4951-97c7-d653252f5add.jpg);
        background-position: 50%;
        background-size: cover;
        position: absolute
    }

    #background-img {
        background-image: url({{$gamePublicFolder}}/e29b8499-d357-4851-837a-42c59e98d6c3.jpg);
        background-position: 50%
    }

    #landscape_cover {
        align-items: center;
        background-color: #000;
        flex-direction: column;
        height: 100vh;
        justify-content: center;
        left: 0;
        opacity: .85;
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 1050
    }

    #landscape_cover img {
        margin-bottom: 20px;
        width: 10%
    }

    #landscape_cover p {
        color: #fff;
        font-size: 5.5vmin;
        margin: 0;
        padding: 0
    }

    #orientation_cover {
        align-items: center;
        background-color: #000;
        flex-direction: column;
        height: 100vh;
        justify-content: center;
        left: 0;
        opacity: .85;
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 1050
    }

    #orientation_cover img {
        margin-bottom: 20px;
        width: 10%
    }

    #orientation_cover p {
        color: #fff;
        font-size: 5.5vmin;
        margin: 0;
        padding: 0
    }

    .orientation_cover_flex {
        display: flex
    }

    .orientation_cover_none {
        display: none
    }

    .landscape_cover_flex {
        display: flex
    }

    .landscape_cover_none {
        display: none
    }

    .mirror {
        transform: scaleX(-1)
    }

    .rotate_icon_scale_translate {
        transform: scale(1.8) translateY(-50%)
    }

    .rotate_icon_scale_translate_land {
        transform: scale(1.8) translateY(-50%) rotate(270deg)
    }

    .rotate_icon_scale_translate.mirror {
        transform: scale(-1.8, 1.8) translateY(-50%)
    }

    #tips-text {
        margin-top: 4px;
        text-align: center;
        text-overflow: ellipsis;
        width: 90%
    }

    .tips-text-child2-hidden {
        display: none
    }

    .tips-text-child2 {
        margin-left: 5px
    }

    @media only screen and (orientation:landscape) {
        .background_ios11 {
            height: 100vmin
        }

        .landscape_cover_show {
            display: flex
        }
    }

    .splash_hidden {
        visibility: hidden
    }

    .start-button-container-land,
    .start-button-container-land-pc,
    .start-button-container-port {
        align-items: center;
        display: flex;
        justify-content: center;
        left: 0;
        margin: auto;
        position: absolute;
        right: 0
    }

    .start-button-container-port {
        height: 32px;
        top: 481px;
        width: 151.7px
    }

    .start-button-container-land,
    .start-button-container-land-pc {
        font-size: 12px;
        height: 22px;
        top: 271px;
        width: 106px
    }

    .start-button {
        background-color: #30a2d0;
        border: 2px solid rgba(0, 0, 0, .15);
        border-radius: 8px;
        text-shadow: 0 2px 3px #30a2d0
    }

    .start-button-show-land,
    .start-button-show-land-pc,
    .start-button-show-port {
        animation-name: show-bounce
    }

    .start-button-show-land,
    .start-button-show-land-pc {
        animation-name: show-bounce-land
    }

    .start-button-inner {
        background-image: linear-gradient(180deg, hsla(0, 0%, 100%, .5), hsla(0, 0%, 100%, 0));
        background-origin: border-box;
        border: .87px solid hsla(0, 0%, 100%, .4);
        border-radius: 6px;
        bottom: 0;
        left: 0;
        position: absolute;
        right: 0;
        top: 0
    }

    .custom-start-button-inner {
        background-position: 50%;
        background-repeat: no-repeat;
        background-size: contain;
        height: 100%;
        left: 50%;
        position: absolute;
        top: 50%;
        transform: translate3d(-50%, -50%, 0);
        width: 100%
    }

    @keyframes show-bounce {
        0% {
            transform: scale(0)
        }

        20% {
            transform: scale(1.2)
        }

        50% {
            transform: scale(.98)
        }

        to {
            transform: scale(1)
        }
    }

    @keyframes show-bounce-land {
        0% {
            transform: scale(0)
        }

        20% {
            transform: scale(.84)
        }

        50% {
            transform: scale(.68)
        }

        to {
            transform: scale(.7)
        }
    }

    .text-land,
    .text-land-pc,
    .text-port {
        color: #fff;
        font-size: 10.3px;
        margin: 0;
        padding: 0
    }

    .text-land,
    .text-land-pc {
        transform: scale(.8)
    }

    .start-button .text-land,
    .start-button .text-land-pc,
    .start-button .text-port {
        font-size: 12px;
        font-weight: 900
    }

    .version {
        bottom: 86px;
        font-size: 12px;
        position: absolute;
        text-align: center;
        width: 100%
    }

    .dark .text-port,
    .lobby .text-port {
        color: #000
    }

    .animationTipsContainer-land,
    .animationTipsContainer-land-pc,
    .animationTipsContainer-port {
        align-items: center;
        display: flex;
        flex-direction: column;
        height: 35px;
        margin: 515px auto 0;
        position: relative;
        width: 100%
    }

    .animationTipsContainer-port {
        margin-top: 515px;
        z-index: 1
    }

    .animationTipsContainer-land,
    .animationTipsContainer-land-pc {
        margin-top: 288px;
        transform: scale(.8)
    }

    .ui_block_page {
        margin: auto;
        z-index: 1100
    }

    .ui_block,
    .ui_block_page {
        background-color: #000;
        bottom: 0;
        left: 0;
        opacity: .6;
        position: absolute;
        right: 0;
        top: 0
    }

    .ui_block {
        transform: translateZ(0)
    }

    @keyframes ui_block_show {
        0% {
            opacity: 0
        }

        to {
            opacity: .6
        }
    }

    @keyframes ui_block_hide {
        0% {
            opacity: .6
        }

        to {
            opacity: 0
        }
    }

    .custom_alert .content .btn_content .button,
    .custom_alert .content .btn_content .custom_button {
        color: inherit;
        font-size: 14px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap
    }

    .custom_alert {
        display: block;
        display: none;
        height: 100%;
        height: 640px;
        margin: auto;
        position: absolute;
        width: inherit;
        width: 360px;
        z-index: 1000
    }

    .custom_alert .content {
        background-color: #fff;
        border-radius: 6px;
        box-shadow: 1px 1px 8.7px #444;
        position: absolute;
        text-align: center;
        width: 243px
    }

    .custom_alert .content .message,
    .custom_alert .content .title {
        font-size: 14px;
        margin-left: 5%;
        margin-right: 5%;
        width: 90%
    }

    .custom_alert .content .message {
        white-space: normal
    }

    .custom_alert .content .title_padding {
        padding-bottom: 0;
        padding-top: 9.7px
    }

    .custom_alert .content .message_padding {
        padding-bottom: 9.7px;
        padding-top: 9.7px
    }

    .custom_alert .content .single_content_padding {
        padding-bottom: 9.7px;
        padding-top: 19.3px
    }

    .custom_alert .content .line_separator {
        border-bottom: 1px solid #000;
        opacity: .1;
        padding-top: 8.7px
    }

    .custom_alert .content .btn_content_row {
        display: table;
        table-layout: fixed;
        width: 100%
    }

    .custom_alert .content .btn_content .button {
        animation: btn_release .1s linear forwards;
        padding: 9.7px 10px 11.3px
    }

    .custom_alert .content .btn_content .button:active {
        animation: btn_press .1s linear forwards
    }

    .custom_alert .content .btn_content .custom_button {
        align-items: center;
        display: flex;
        height: 32px;
        justify-content: center
    }

    .custom_alert .content .btn_content .row {
        display: table-cell
    }

    .custom_alert .content .btn_content .btn_separator_height {
        background-color: #000;
        height: 1px;
        opacity: .1;
        width: inherit
    }

    .custom_alert .content .btn_content .btn_separator_width {
        background-color: #000;
        height: inherit;
        opacity: .1;
        width: 1px
    }

    .custom_alert .custom_content {
        padding: 20px
    }

    @media screen and (orientation:portrait) {
        .custom_alert {
            display: block;
            height: 100%;
            height: 640px;
            position: absolute;
            width: inherit;
            width: 360px;
            z-index: 1000
        }
    }

    @media screen and (orientation:landscape) {
        .custom_alert {
            display: none;
            height: 100%;
            height: 640px;
            position: absolute;
            width: inherit;
            width: 360px;
            z-index: 1000
        }
    }

    .custom_alert_ignore_orientation {
        display: block;
        height: 100%;
        height: 640px;
        position: absolute;
        width: inherit;
        width: 360px;
        z-index: 1000
    }

    @keyframes custom_alert_anim_show {
        0% {
            opacity: 0
        }

        60% {
            opacity: 1;
            transform: scale(1)
        }

        80% {
            opacity: 1;
            transform: scale(1.12)
        }

        to {
            opacity: 1;
            transform: scale(1)
        }
    }

    @keyframes custom_alert_anim_hide {
        0% {
            opacity: 1
        }

        to {
            opacity: 0
        }
    }

    .custom_alert_show {
        animation: custom_alert_anim_show .3s linear forwards
    }

    @keyframes btn_press {
        0% {
            opacity: 1
        }

        to {
            opacity: .5
        }
    }

    @keyframes btn_release {
        0% {
            opacity: .5
        }

        to {
            opacity: 1
        }
    }

    .errorlabel {
        font-size: 10px
    }

    .animated_text_wrap {
        color: #fff;
        font-size: 10px;
        height: 26px;
        line-height: 26px;
        position: relative;
        text-align: center;
        width: 100%
    }

    .dark .animated_text_wrap,
    .lobby .animated_text_wrap {
        color: #000
    }

    .animated_text_wrap_hide {
        display: none
    }

    .animated_text {
        align-items: center;
        display: flex;
        height: 26px;
        justify-content: center;
        line-height: 13px;
        margin: 0;
        opacity: 0;
        position: absolute;
        top: 100%;
        width: 100%
    }

    .animated-text-move-to-top-port,
    .animated-text-reset-to-bottom-port {
        opacity: 0
    }

    .animated-text-reset-to-bottom-port {
        top: 26px
    }

    .animated-text-move-to-top-port,
    .animated_text_move_to_center {
        transition: top 1s, opacity 1s;
        transition-timing-function: linear
    }

    .animated_text_move_to_center {
        opacity: 1;
        top: 0
    }

    .animated-text-move-to-top-port {
        top: -30px
    }

    .sprite_main_res {
        background-image: url({{$gamePublicFolder}}/https://static.pgsoft-games.com/shared/ad52f8ee3c/e2cf6fa310.663ff.png);
        background-repeat: no-repeat;
        background-size: 222px 248px;
        display: inline-block
    }

    .ic_360 {
        background-position: -162px -217px;
        height: 21px;
        width: 20px
    }

    .ic_arrow_back {
        background-position: -110px -181px;
        height: 22px;
        width: 22px
    }

    .ic_arrow_right {
        background-position: -211px -95px;
        height: 12px;
        width: 8px
    }

    .ic_chrome {
        background-position: -182px -193px;
        height: 20px;
        width: 20px
    }

    .ic_close_white {
        background-position: -187px -95px;
        height: 22px;
        width: 22px
    }

    .ic_dialog_close {
        background-position: -134px -181px;
        height: 22px;
        width: 22px
    }

    .ic_iconic {
        background-position: -1px -1px;
        height: 178px;
        width: 158px
    }

    .ic_ios_share_button {
        background-position: -184px -215px;
        height: 23px;
        width: 16px
    }

    .ic_operator_logo_details {
        background-position: -68px -223px;
        height: 24px;
        width: 92px
    }

    .ic_operator_select {
        background-position: -187px -119px;
        height: 22px;
        width: 22px
    }

    .ic_pg_logo {
        background-position: -68px -181px;
        height: 40px;
        width: 40px
    }

    .ic_pg_logo_small {
        background-position: -110px -205px;
        height: 12px;
        width: 27px
    }

    .ic_qq {
        background-position: -187px -143px
    }

    .ic_qq,
    .ic_quark {
        height: 22px;
        width: 22px
    }

    .ic_quark {
        background-position: -187px -167px
    }

    .ic_rotate_screen {
        background-position: -161px -1px;
        height: 60px;
        width: 60px
    }

    .ic_step_1 {
        background-position: -204px -191px;
        height: 14px;
        width: 14px
    }

    .ic_step_2 {
        background-position: -139px -205px;
        height: 14px;
        width: 15px
    }

    .ic_step_arrow {
        background-position: -211px -109px;
        height: 12px;
        width: 7px
    }

    .ic_swipeup_arrow {
        background-position: -161px -63px;
        height: 128px;
        width: 24px
    }

    .ic_swipeup_hand {
        background-position: -1px -181px;
        height: 55px;
        width: 65px
    }

    .ic_swipeup_round {
        background-position: -187px -63px;
        height: 30px;
        width: 30px
    }

    .ic_uc {
        background-position: -158px -193px;
        height: 22px;
        width: 22px
    }

    .loading-container-land,
    .loading-container-land-pc,
    .loading-container-port {
        align-items: center;
        display: flex;
        flex-direction: column;
        left: 0;
        position: absolute;
        right: 0
    }

    .loading-container-port {
        top: 477px
    }

    .loading-container-land,
    .loading-container-land-pc {
        top: 265px
    }

    .progress-bar-container-land,
    .progress-bar-container-land-pc,
    .progress-bar-container-port {
        background-color: initial;
        height: 13px;
        position: relative;
        width: 212px
    }

    .progress-bar-container-land,
    .progress-bar-container-land-pc {
        transform: scale(.7)
    }

    .progress-bar-background {
        background-color: #111;
        border-radius: 3.5px;
        height: 100%;
        position: absolute;
        width: 100%
    }

    .progress-bar-outline {
        border-radius: 3.5px;
        bottom: 0;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transform: translateZ(0)
    }

    .border-inner {
        border: 1.7px solid #272727
    }

    .border-outer {
        border: .85px solid #111
    }

    .progress-bar-fill-container {
        bottom: .87px;
        left: .87px;
        position: absolute;
        right: .87px;
        top: .87px
    }

    .progress-bar-fill {
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        background-color: #30a2d0;
        background-size: 8.7px 100%;
        border-radius: 3.5px;
        height: 100%;
        position: absolute;
        width: 0
    }

    .stripes {
        animation-duration: 1s;
        animation-iteration-count: infinite;
        animation-name: animate-stripes;
        animation-timing-function: linear;
        background-image: linear-gradient(-75deg, hsla(0, 0%, 100%, 0) 35%, hsla(0, 0%, 100%, .1) 0, hsla(0, 0%, 100%, .1) 75%, hsla(0, 0%, 100%, 0) 0, hsla(0, 0%, 100%, 0))
    }

    .front-highlight {
        background-image: linear-gradient(90deg, hsla(0, 0%, 100%, 0), #fff);
        border-radius: 0 3.5px 3.5px 0;
        height: 100%;
        max-width: 20px;
        right: 0;
        width: 50%
    }

    .front-highlight,
    .top-highlight {
        position: absolute;
        transform: translateZ(0)
    }

    .top-highlight {
        background-color: hsla(0, 0%, 100%, .2);
        border-radius: 3.5px 3.5px 0 0;
        height: 50%;
        width: 100%
    }

    @keyframes animate-stripes {
        0% {
            background-position: 0 0
        }

        to {
            background-position: 34.7px 0
        }
    }

    .custom-progress-bar-container {
        align-items: center;
        display: flex;
        height: 40px;
        justify-content: center;
        width: 240px
    }

    .custom-progress-bar-background {
        background-position: 50%;
        background-repeat: no-repeat;
        background-size: contain;
        height: 100%;
        left: 0;
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 3
    }

    .custom-progress-bar-fill-container {
        border-radius: 3px;
        height: 24px;
        left: 50%;
        position: absolute;
        top: 50%;
        transform: translate3d(-50%, -50%, 0);
        width: 221px;
        z-index: 2
    }

    .lobby .progress-bar-background {
        background-color: #f5f5f5
    }

    .lobby .border-outer {
        display: none
    }

    .lobby .border-inner {
        border: 1.7px solid #f5f5f5
    }

    .lobby .front-highlight {
        opacity: .5
    }

    .lobby .top-highlight {
        display: none
    }

    #npveSplash {
        z-index: 975
    }

    .npve_container .npve_bottom_content .npve_bottom_button_title_land,
    .npve_container .npve_bottom_content .npve_bottom_button_title_port,
    .npve_container .npve_bottom_content .npve_bottom_land,
    .npve_container .npve_bottom_content .npve_bottom_port,
    .npve_container .npve_bottom_content .npve_grid_1,
    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_row .grid_desc,
    .npve_container .npve_bottom_content .npve_text_bold_port,
    .npve_container .npve_bottom_content .npve_text_content_land,
    .npve_container .npve_bottom_content .npve_text_content_port,
    .npve_container .npve_bottom_content .npve_text_note_land,
    .npve_container .npve_bottom_content .npve_text_note_port,
    .npve_container .npve_bottom_content .npve_text_wrapper_land,
    .npve_container .npve_bottom_content .npve_text_wrapper_port,
    .npve_container .npve_middle_content .npve_main_desc_land,
    .npve_container .npve_middle_content .npve_main_desc_port {
        transform: scale(.87)
    }

    .npve_container .npve_middle_content .npve_continue_desc_land,
    .npve_container .npve_middle_content .npve_continue_desc_port {
        transform: scale(.75)
    }

    .npve_screen_compact {
        background-color: #fff;
        height: 640px;
        margin: auto;
        position: absolute;
        transform: translateZ(0);
        width: 360px
    }

    .npve_visible {
        visibility: visible
    }

    .npve_container {
        background-color: #fff;
        display: flex;
        flex-direction: column;
        font-size: 12px;
        height: 100%;
        position: relative;
        width: 100%
    }

    .npve_container .npve_top_content {
        display: flex;
        justify-content: space-between;
        margin: 26px
    }

    .npve_container .npve_top_content .title {
        color: #000;
        font-size: 16px;
        line-height: 16px;
        max-width: 216.7px;
        text-align: right
    }

    .npve_container .npve_middle_content_port {
        margin: 0 43.3px
    }

    .npve_container .npve_middle_content {
        align-items: center;
        display: flex;
        flex-direction: column;
        justify-content: center
    }

    .npve_container .npve_middle_content .npve_iconic_port {
        display: table;
        transform: scale(.87)
    }

    .npve_container .npve_middle_content .npve_iconic_land {
        display: table;
        margin-top: -90px;
        transform: scale(.62)
    }

    .npve_container .npve_middle_content .npve_main_desc_land,
    .npve_container .npve_middle_content .npve_main_desc_port {
        color: #000;
        display: flex;
        line-height: 20px
    }

    .npve_container .npve_middle_content .npve_main_desc_port {
        line-height: 26px;
        margin-top: -16px;
        min-height: 150px;
        text-align: justify;
        width: 312px
    }

    .npve_container .npve_middle_content .npve_main_desc_land {
        justify-content: center;
        margin: -25px 0 10px;
        min-height: 50px;
        text-align: center;
        width: 700px
    }

    .npve_container .npve_middle_content .npve_continue_button:hover,
    .npve_container .npve_middle_content .npve_continue_button_land:hover,
    .npve_container .npve_middle_content .npve_continue_button_port:hover {
        cursor: pointer;
        opacity: .5
    }

    .npve_container .npve_middle_content .npve_continue_button,
    .npve_container .npve_middle_content .npve_continue_button_land,
    .npve_container .npve_middle_content .npve_continue_button_port {
        background-color: rgba(81, 211, 33, .2);
        border: 1px solid #51d321;
        border-radius: 4px;
        color: #50d221;
        text-align: center;
        width: 100%
    }

    .npve_container .npve_middle_content .npve_continue_button_port {
        height: 43.3px;
        line-height: 43.3px
    }

    .npve_container .npve_middle_content .npve_continue_button_land {
        font-size: 13px;
        height: 32px;
        line-height: 32px;
        width: 314px
    }

    .npve_container .npve_middle_content .npve_continue_button_active {
        opacity: .5
    }

    .npve_container .npve_middle_content .npve_continue_desc_land,
    .npve_container .npve_middle_content .npve_continue_desc_port {
        color: #000;
        line-height: 17.3px;
        opacity: .3;
        text-align: center
    }

    .npve_container .npve_middle_content .npve_continue_desc_port {
        margin-top: 5px;
        width: 364px
    }

    .npve_container .npve_middle_content .npve_continue_desc_land {
        height: 34px;
        margin-top: 8px;
        width: 736px
    }

    .npve_container .npve_bottom_content_port {
        min-height: 130px
    }

    .npve_container .npve_bottom_content_land {
        max-height: 80px;
        min-height: 60px
    }

    .npve_container .npve_bottom_content {
        bottom: 0;
        display: flex;
        flex: 1;
        flex-direction: column;
        left: 0;
        position: absolute;
        right: 0
    }

    .npve_container .npve_bottom_content .npve_separate_line_port {
        background-color: #000;
        height: 1.3px;
        margin-left: 43.3px;
        margin-right: 43.3px;
        margin-top: 10px;
        opacity: .1
    }

    .npve_container .npve_bottom_content .npve_separate_line_land {
        background-color: #000;
        height: 1.3px;
        margin-left: 20px;
        margin-right: 20px;
        opacity: .1
    }

    .npve_container .npve_bottom_content .npve_bottom_port {
        display: block
    }

    .npve_container .npve_bottom_content .npve_bottom_land {
        align-items: center;
        display: flex;
        justify-content: center;
        min-height: 60px
    }

    .npve_container .npve_bottom_content .npve_bottom_button_title_land,
    .npve_container .npve_bottom_content .npve_bottom_button_title_port,
    .npve_container .npve_bottom_content .npve_text_wrapper_land,
    .npve_container .npve_bottom_content .npve_text_wrapper_port {
        color: #000;
        flex: 1;
        line-height: 14px
    }

    .npve_container .npve_bottom_content .npve_bottom_button_title_port {
        margin-bottom: 10px;
        margin-top: 10px;
        text-align: justify
    }

    .npve_container .npve_bottom_content .npve_bottom_button_title_land {
        display: block;
        margin-right: 30px;
        max-width: 260px;
        min-width: 260px;
        text-align: center
    }

    .npve_container .npve_bottom_content .npve_text_wrapper_port {
        text-align: justify
    }

    .npve_container .npve_bottom_content .npve_text_wrapper_land {
        align-items: center;
        display: flex;
        flex-direction: column;
        justify-content: center
    }

    .npve_container .npve_bottom_content .npve_text_content_land,
    .npve_container .npve_bottom_content .npve_text_content_port {
        align-items: center;
        display: flex
    }

    .npve_container .npve_bottom_content .npve_text_content_port {
        justify-content: left
    }

    .npve_container .npve_bottom_content .npve_text_content_land {
        justify-content: center;
        width: 736px
    }

    .npve_container .npve_bottom_content .npve_text_bold_port {
        font-weight: 700;
        margin: 10px 0
    }

    .npve_container .npve_bottom_content .npve_text_bold_land {
        font-weight: 700;
        margin-right: 16px;
        max-width: 200px;
        text-align: center
    }

    .npve_container .npve_bottom_content .npve_line_text_port {
        max-width: 130px;
        text-align: justify
    }

    .npve_container .npve_bottom_content .npve_line_text_land {
        max-width: 250px;
        text-align: justify
    }

    .npve_container .npve_bottom_content .npve_line_num {
        margin-right: 12px;
        min-width: 14px;
        transform: scale(1.2)
    }

    .npve_container .npve_bottom_content .npve_line_arrow_land,
    .npve_container .npve_bottom_content .npve_line_arrow_port {
        min-width: 7px;
        transform: scale(1.2)
    }

    .npve_container .npve_bottom_content .npve_line_arrow_port {
        margin: 0 20px
    }

    .npve_container .npve_bottom_content .npve_line_arrow_land {
        margin: 0 16px
    }

    .npve_container .npve_bottom_content .npve_text_note_land,
    .npve_container .npve_bottom_content .npve_text_note_port {
        line-height: 16px;
        opacity: .3
    }

    .npve_container .npve_bottom_content .npve_text_note_port {
        margin-top: 15px;
        text-align: justify
    }

    .npve_container .npve_bottom_content .npve_text_note_land {
        margin-top: 11px;
        text-align: center;
        width: 736px
    }

    .npve_container .npve_bottom_content .npve_grid_1 {
        align-items: center;
        display: flex;
        flex: 2;
        justify-content: center
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content:hover {
        color: #0f55cc;
        cursor: pointer
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content {
        align-items: center;
        color: #000;
        display: flex;
        flex: 1;
        flex-direction: column
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_row {
        align-items: center;
        display: flex;
        flex-direction: row
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_row .grid_icon {
        min-width: 20px
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_row .grid_desc {
        display: block;
        line-height: 12px;
        margin-left: 5px;
        max-width: 150px;
        text-align: left
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_row .grid_desc .grid_desc_title {
        text-decoration: underline
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_row .grid_desc .grid_desc_seperator {
        height: 5px
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_row .grid_desc .grid_desc_content {
        opacity: .3
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_row .grid_desc_active_color {
        color: #0f55cc
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_text {
        color: #000;
        display: flex;
        flex: 1;
        line-height: 10px;
        opacity: .3;
        text-align: center
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_text_center {
        justify-content: center
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_text_left {
        justify-content: flex-start
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_content .grid_text_right {
        justify-content: flex-end
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_item_center {
        align-items: center
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_item_left {
        align-items: flex-start
    }

    .npve_container .npve_bottom_content .npve_grid_1 .grid_item_right {
        align-items: flex-end
    }

    .qpage {
        background-color: #fff;
        height: 640px;
        margin: auto;
        position: absolute;
        width: 360px;
        z-index: 975
    }

    .qpage_container {
        background-color: #fff;
        display: flex;
        flex-direction: column;
        height: 100%;
        text-align: center;
        width: 100%;
        z-index: 950
    }

    .qpage_container .qpage_content {
        align-items: center;
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: center
    }

    .qpage_container .qpage_content .qpage_boy {
        transform: scale(.82)
    }

    .qpage_container .qpage_content .qpage_title {
        color: #000;
        font-size: 20px;
        line-height: 20px;
        position: relative;
        text-align: center;
        top: 0;
        width: 80%
    }

    .qpage_container .qpage_content .qpage_desc {
        color: #000;
        font-size: 11.3px;
        line-height: 14px;
        opacity: .3;
        position: relative;
        text-align: center;
        top: 8.7px;
        width: 80%
    }

    .qpage_container .qpage_content .qpage_button {
        background-color: rgba(24, 17, 84, .075);
        border-radius: 2px;
        color: #000;
        font-size: 10.3px;
        height: 36.3px;
        line-height: 36.3px;
        margin-top: 20px;
        max-width: 303.3px;
        min-width: 156px
    }

    .footer-container {
        display: flex;
        height: 77px
    }

    .footer-container,
    .footer-mask-container-land,
    .footer-mask-container-port {
        bottom: 0;
        position: absolute;
        width: 100%
    }

    .footer-mask-container-port {
        display: flex;
        flex-direction: column;
        height: 219.3px
    }

    .footer-mask-container-land {
        height: 140px
    }

    .footer-mask {
        height: 100%;
        position: absolute;
        width: 100%
    }

    .footer-mask-black {
        background-image: linear-gradient(180deg, transparent, rgba(0, 0, 0, .3))
    }

    .footer-mask-color {
        background-image: linear-gradient(180deg, hsla(0, 0%, 100%, 0), #fff)
    }

    .footer-container img {
        height: 117px;
        width: 100%
    }

    .footer-image-container {
        height: 100%;
        overflow: hidden;
        position: absolute;
        width: 100%;
        z-index: 0
    }

    .footer-image-land,
    .footer-image-land-pc,
    .footer-image-port {
        background-image: url({{$gamePublicFolder}}/blob:https://m.pgsoft-games.com/f55c3e01-e65a-4bc6-9610-9d2f8e0a3307);
        background-position: 50%;
        background-size: cover;
        position: absolute
    }

    .footer-image-port {
        height: 126px;
        width: 360px
    }

    .footer-image-land,
    .footer-image-land-pc {
        bottom: 0;
        height: 47px;
        width: 100%
    }

    .footer-tag-port {
        top: -20px;
        z-index: 1
    }

    .footer-tag-port,
    .tag-container {
        height: 40px;
        position: absolute;
        right: 10px;
        width: 40px
    }

    .tag-canvas {
        height: 40px;
        width: 40px
    }

    .lobby .footer-mask-container-port {
        display: none
    }

    .swipeup_text {
        bottom: 40px;
        font-size: 12px
    }

    .swipeup_container,
    .swipeup_text {
        color: #fff;
        left: 0;
        position: absolute;
        right: 0
    }

    .swipeup_container {
        bottom: 0;
        height: 270px;
        margin: auto;
        top: 0;
        width: 224px
    }

    .swipeup_slide_container {
        left: 50%;
        position: absolute;
        top: 29px;
        transform: scale(1);
        transform-origin: center top
    }

    .swipeup_background {
        animation: swipeup_background_anim .75s forwards;
        background-color: #000;
        border-radius: 7px;
        height: 100%;
        opacity: .8;
        width: 100%
    }

    .swipeup_arrow {
        animation: swipeup_arrow_fade_anim, swipeup_arrow_clip_anim;
        animation-duration: 2.4s, 2.4s;
        animation-iteration-count: infinite, infinite;
        animation-timing-function: ease, cubic-bezier(.84, 0, .16, 1);
        left: -12px;
        opacity: 0;
        position: absolute
    }

    .swipeup_slide {
        animation: swipeup_slide_anim;
        animation-duration: 2.4s;
        animation-iteration-count: infinite;
        animation-timing-function: cubic-bezier(.84, 0, .16, 1);
        position: absolute;
        top: 126px
    }

    .swipeup_round {
        animation: swipeup_round_anim 2.4s infinite;
        left: -16px;
        opacity: 1;
        position: absolute;
        top: -20px
    }

    .swipeup_hand {
        animation: swipeup_hand_anim 2.4s infinite;
        left: -9px;
        opacity: 1;
        position: absolute;
        top: -12px
    }

    @keyframes swipeup_background_anim {
        0% {
            opacity: 0
        }

        to {
            opacity: .8
        }
    }

    @keyframes swipeup_arrow_clip_anim {

        0%,
        33% {
            height: 129px
        }

        to {
            height: 0
        }
    }

    @keyframes swipeup_arrow_fade_anim {

        0%,
        17% {
            opacity: 0
        }

        50%,
        to {
            opacity: .6
        }
    }

    @keyframes swipeup_slide_anim {

        0%,
        33% {
            transform: translateY(0)
        }

        to {
            transform: translateY(-120px)
        }
    }

    @keyframes swipeup_round_anim {
        0% {
            opacity: 0
        }

        33%,
        to {
            opacity: 1
        }
    }

    @keyframes swipeup_hand_anim {
        0% {
            transform: scale(1)
        }

        33%,
        to {
            transform: scale(.9)
        }
    }

    #canvas-shadow {
        background-color: #000;
        display: block;
        -webkit-filter: drop-shadow(2px 2px 10px rgba(0, 0, 0, .5));
        filter: drop-shadow(2px 2px 10px rgba(0, 0, 0, .5));
        height: 736px;
        position: absolute;
        width: 414px
    }

    .lobby #canvas-shadow {
        -webkit-filter: drop-shadow(2px 2px 10px rgba(0, 0, 0, .12));
        filter: drop-shadow(2px 2px 10px rgba(0, 0, 0, .12))
    }

    .slot_alert {
        background-color: rgba(47, 47, 59, .95);
        border-radius: 6px;
        box-shadow: .87px .87px 8.7px #292929;
        padding: 13px 21.7px;
        position: absolute;
        text-align: center;
        width: 243.3px
    }

    .card_alert .content .slot_alert .message,
    .card_alert .content .slot_alert .title,
    .slot_alert .card_alert .content .message,
    .slot_alert .card_alert .content .title,
    .slot_alert .message,
    .slot_alert .slot_alert_landscape .message_landscape,
    .slot_alert .slot_alert_landscape .title_landscape,
    .slot_alert .title,
    .slot_alert_landscape .slot_alert .message_landscape,
    .slot_alert_landscape .slot_alert .title_landscape {
        color: #d9d9d9;
        white-space: normal
    }

    .slot_alert .title {
        font-size: 15.7px
    }

    .slot_alert .message {
        font-size: 13.3px
    }

    .slot_alert .single_content_padding {
        padding-bottom: 17.3px !important;
        padding-top: 8.7px !important
    }

    .slot_alert .title_padding {
        padding-bottom: 0;
        padding-top: 0
    }

    .slot_alert .message_padding {
        padding-bottom: 17.3px;
        padding-top: 17.3px
    }

    .slot_alert .message u {
        border-bottom: 1.7px solid;
        display: inline-block;
        text-decoration: none
    }

    .slot_alert .btn_content_row {
        display: table;
        table-layout: fixed;
        width: 100%
    }

    .slot_alert .btn_content {
        margin-left: 2%;
        margin-right: 2%;
        width: 96%
    }

    .slot_alert .btn_content .button {
        background-color: #dd5c2a;
        border-radius: 2.6px;
        color: #d9d9d9;
        font-size: 13.3px;
        margin: 3.5px;
        min-height: 17.3px;
        opacity: 1;
        padding: 10.3px 8.7px
    }

    .slot_alert .btn_content .button:active {
        opacity: .85
    }

    .slot_alert .btn_content .row {
        display: table-cell;
        padding-left: 4.3px;
        padding-right: 4.3px;
        vertical-align: middle
    }

    .slot_alert .btn_content .btn_seperator_height {
        content: "";
        display: block;
        height: 2.6px;
        width: inherit
    }

    .slot_alert .btn_content .btn_seperator_width {
        content: "";
        display: table-cell;
        height: inherit;
        width: 8.7px
    }

    .slot_alert_landscape {
        background-color: rgba(47, 47, 59, .95);
        border-radius: 6px;
        box-shadow: .87px .87px 8.7px #292929;
        padding: 16px 18.7px;
        position: absolute;
        text-align: center;
        width: 184px
    }

    .card_alert .content .slot_alert_landscape .message,
    .card_alert .content .slot_alert_landscape .title,
    .slot_alert .slot_alert_landscape .message,
    .slot_alert .slot_alert_landscape .title,
    .slot_alert_landscape .card_alert .content .message,
    .slot_alert_landscape .card_alert .content .title,
    .slot_alert_landscape .message_landscape,
    .slot_alert_landscape .slot_alert .message,
    .slot_alert_landscape .slot_alert .title,
    .slot_alert_landscape .title_landscape {
        color: #d9d9d9;
        white-space: normal
    }

    .slot_alert_landscape .title_landscape {
        font-size: 12.7px
    }

    .slot_alert_landscape .message_landscape {
        font-size: 10.3px
    }

    .slot_alert_landscape .single_content_padding_landscape {
        padding-bottom: 17.3px !important;
        padding-top: 8.7px !important
    }

    .slot_alert_landscape .title_padding_landscape {
        padding-bottom: 0;
        padding-top: 0
    }

    .slot_alert_landscape .message_landscape_padding {
        padding-bottom: 17.3px;
        padding-top: 17.3px
    }

    .slot_alert_landscape .message_landscape u {
        border-bottom: 1.7px solid;
        display: inline-block;
        text-decoration: none
    }

    .slot_alert_landscape .btn_content_row_landscape {
        display: table;
        table-layout: fixed;
        width: 100%
    }

    .slot_alert_landscape .btn_content_landscape {
        margin-right: 2%;
        width: 100%
    }

    .slot_alert_landscape .btn_content_landscape .button_landscape {
        background-color: #dd5c2a;
        border-radius: 2.6px;
        color: #d9d9d9;
        font-size: 10.3px;
        margin: 3.5px;
        min-height: 17.3px;
        opacity: 1;
        padding: 8.3px 8.7px
    }

    .slot_alert_landscape .btn_content_landscape .button_landscape:active {
        opacity: .85
    }

    .slot_alert_landscape .btn_content_landscape .row_landscape {
        display: table-cell;
        padding-left: 4.3px;
        padding-right: 4.3px;
        vertical-align: middle
    }

    .slot_alert_landscape .btn_content_landscape .btn_seperator_height_landscape {
        content: "";
        display: block;
        height: 2.6px;
        width: inherit
    }

    .slot_alert_landscape .btn_content_landscape .btn_seperator_width_landscape {
        content: "";
        display: table-cell;
        height: inherit;
        width: 8.7px
    }

    .lobby_alert {
        background-color: #fff;
        border-radius: 6px;
        box-shadow: .87px .87px 3.5px #444;
        position: absolute;
        text-align: center;
        width: 243.3px
    }

    .lobby_alert .title {
        font-size: 12px;
        white-space: nowrap
    }

    .lobby_alert .message {
        font-size: 12px;
        white-space: normal
    }

    .lobby_alert .single_content_padding {
        padding-bottom: 9.7px;
        padding-top: 19.3px
    }

    .lobby_alert .title_padding {
        padding-bottom: 0;
        padding-top: 9.7px
    }

    .lobby_alert .message_padding {
        padding-bottom: 9.7px;
        padding-top: 9.7px
    }

    .lobby_alert .message u {
        border-bottom: 1.7px solid;
        display: inline-block;
        text-decoration: none
    }

    .lobby_alert .line_separator {
        border-bottom: .87px solid #000;
        opacity: .1;
        padding-top: 8.7px
    }

    .lobby_alert .btn_content_row {
        display: table;
        table-layout: fixed;
        width: 100%
    }

    .lobby_alert .btn_content {
        margin-left: 2%;
        margin-right: 2%;
        width: 96%
    }

    .lobby_alert .btn_content .button {
        font-size: 13.7px;
        opacity: 1;
        padding-bottom: 11.3px;
        padding-top: 9.7px
    }

    .lobby_alert .btn_content .button .text {
        color: inherit;
        font-size: inherit;
        overflow: hidden;
        pointer-events: none;
        text-overflow: ellipsis;
        white-space: nowrap
    }

    .lobby_alert .btn_content .button:active {
        opacity: .85
    }

    .lobby_alert .btn_content .row {
        display: table-cell
    }

    .lobby_alert .btn_content .btn_seperator_height {
        background-color: #000;
        content: "";
        display: block;
        height: .87px;
        margin-left: -2%;
        opacity: .1;
        width: 104%
    }

    .lobby_alert .btn_content .btn_seperator_width {
        background-color: #000;
        content: "";
        display: table-cell;
        height: inherit;
        opacity: .1;
        width: 1px
    }

    .card_alert .content .message,
    .card_alert .content .slot_alert_landscape .message_landscape,
    .card_alert .content .slot_alert_landscape .title_landscape,
    .card_alert .content .title,
    .lobby_alert .message,
    .lobby_alert .title,
    .slot_alert .message,
    .slot_alert .slot_alert_landscape .message_landscape,
    .slot_alert .slot_alert_landscape .title_landscape,
    .slot_alert .title,
    .slot_alert_landscape .card_alert .content .message_landscape,
    .slot_alert_landscape .card_alert .content .title_landscape,
    .slot_alert_landscape .slot_alert .message_landscape,
    .slot_alert_landscape .slot_alert .title_landscape {
        margin-left: 5%;
        margin-right: 5%;
        overflow: hidden;
        width: 90%
    }

    .card_alert .content .slot_alert_landscape .message,
    .card_alert .content .slot_alert_landscape .title,
    .slot_alert .slot_alert_landscape .message,
    .slot_alert .slot_alert_landscape .title,
    .slot_alert_landscape .card_alert .content .message,
    .slot_alert_landscape .card_alert .content .title,
    .slot_alert_landscape .message_landscape,
    .slot_alert_landscape .slot_alert .message,
    .slot_alert_landscape .slot_alert .title,
    .slot_alert_landscape .title_landscape {
        margin-left: 10%;
        margin-right: 5%;
        overflow: hidden;
        width: 80%
    }

    .card_alert .content .btn_content .button .text,
    .slot_alert .btn_content .button .text,
    .slot_alert_landscape .btn_content_landscape .button_landscape .text_landscape {
        color: inherit;
        font-size: inherit;
        overflow: hidden;
        pointer-events: none;
        text-overflow: ellipsis;
        white-space: nowrap
    }

    @keyframes alert_anim_show {
        0% {
            opacity: 0
        }

        60% {
            opacity: 1;
            transform: scale(1)
        }

        80% {
            opacity: 1;
            transform: scale(1.12)
        }

        to {
            opacity: 1;
            transform: scale(1)
        }
    }

    @keyframes alert_anim_hide {
        0% {
            opacity: 1
        }

        to {
            opacity: 0
        }
    }

    .card_alert_show,
    .lobby_alert_show,
    .slot_alert_show,
    .slot_alert_show_landscape {
        animation: alert_anim_show .3s linear forwards;
        display: block
    }

    .card_alert_hide,
    .lobby_alert_hide,
    .slot_alert_hide,
    .slot_alert_hide_landscape {
        animation: alert_anim_hide .2s linear forwards
    }

    @keyframes card_btn_press {
        0% {
            opacity: 1
        }

        to {
            opacity: .4
        }
    }

    @keyframes card_btn_release {
        0% {
            opacity: .4
        }

        to {
            opacity: 1
        }
    }

    .card_alert .container {
        display: block;
        height: 100%;
        position: absolute;
        width: 100%
    }

    .card_alert .content {
        border-radius: 10.3px;
        box-shadow: 0 0 17.3px 3.5px #0c0b0b;
        padding: 13px 21.7px;
        position: absolute;
        text-align: center;
        width: 291.3px
    }

    .card_alert .content .message,
    .card_alert .content .slot_alert_landscape .message_landscape,
    .card_alert .content .slot_alert_landscape .title_landscape,
    .card_alert .content .title,
    .slot_alert_landscape .card_alert .content .message_landscape,
    .slot_alert_landscape .card_alert .content .title_landscape {
        color: #d9d9d9;
        white-space: normal
    }

    .card_alert .content .title {
        font-size: 15px
    }

    .card_alert .content .message {
        font-size: 14px
    }

    .card_alert .content .single_content_padding {
        padding-bottom: 9.7px !important;
        padding-top: 19.3px !important
    }

    .card_alert .content .title_padding {
        padding-bottom: 0;
        padding-top: 9.7px
    }

    .card_alert .content .message_padding {
        padding-bottom: 9.7px;
        padding-top: 9.7px
    }

    .card_alert .content .message u {
        border-bottom: 5px solid;
        display: inline-block;
        text-decoration: none
    }

    .card_alert .content .btn_content_row {
        display: flex;
        justify-content: space-between;
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding-bottom: 13px;
        padding-top: 13px;
        width: 100% !important
    }

    .card_alert .content .btn_content {
        margin-left: 10%;
        margin-right: 10%;
        width: 80%
    }

    .card_alert .content .btn_content .button {
        background: #cb951a;
        background: linear-gradient(180deg, #ffec50, #ffe470 44%, #d28c00 80%, #d09500 95%);
        border-radius: 30px;
        color: #140c05;
        font-size: 15.7px;
        font-weight: 700;
        margin: 4px -30px 10px;
        min-height: 17.3px;
        opacity: 1;
        padding: 12px
    }

    .card_alert .content .btn_content .button:active {
        opacity: .85
    }

    .card_alert .content .btn_content .row {
        margin-left: 0;
        margin-right: 0;
        width: 45%
    }

    .card_alert .content .btn_content .btn_seperator_height {
        display: none
    }

    .card_alert .content .btn_content .btn_seperator_width {
        content: "";
        height: inherit;
        width: 20px
    }

    .card_alert .frame {
        background-color: #140c05;
        border: 4px solid #503333;
        border-radius: 10.3px;
        left: -4px;
        position: absolute;
        top: -4px
    }

    .alert_holder {
        bottom: 0;
        left: 0;
        overflow: hidden;
        position: absolute;
        right: 0;
        top: 0;
        z-index: 1000
    }

    .alert_holder .screen_center {
        left: 0;
        margin: auto;
        position: absolute;
        right: 0
    }

    .loading_circle_container,
    .loading_container,
    .loading_holder,
    .loading_panel {
        bottom: 0;
        left: 0;
        position: absolute;
        right: 0;
        top: 0
    }

    .loading_holder,
    .loading_panel {
        height: auto;
        overflow: hidden;
        width: 360px
    }

    .loading_holder {
        max-height: 780px;
        min-height: 640px;
        z-index: 900
    }

    .loading_panel {
        top: 800px
    }

    .loading_container {
        height: inherit;
        margin: auto;
        min-height: inherit;
        min-width: inherit;
        overflow: hidden;
        text-align: center;
        width: inherit
    }

    .loading_background {
        height: 100%;
        width: 100%
    }

    .loading_font {
        bottom: 0;
        color: #30a2d0;
        font-size: 15.7px;
        left: 0;
        line-height: 21.7px;
        margin: auto;
        max-height: 65px;
        overflow: hidden;
        padding-left: 7%;
        padding-right: 7%;
        position: absolute;
        right: 0;
        top: 52px;
        width: 86%
    }

    .loading_circle_container {
        align-items: center;
        bottom: 34.7px;
        display: flex;
        height: 8.7px;
        justify-content: space-between;
        margin: auto;
        position: absolute;
        width: 26px
    }

    .loading_circle_container_center {
        bottom: 0
    }

    .loading_circle {
        animation-direction: alternate;
        animation-duration: .25s;
        animation-iteration-count: infinite;
        animation-name: loading_circle_bounce;
        animation-timing-function: ease-out;
        background-color: #30a2d0;
        border-radius: 50%;
        height: 6px;
        position: relative;
        width: 6px
    }

    .loading_circle:first-of-type {
        animation-delay: 0s
    }

    .loading_circle:nth-of-type(2) {
        animation-delay: -75ms
    }

    .loading_circle:nth-of-type(3) {
        animation-delay: -.15s
    }

    @keyframes loading_circle_bounce {
        0% {
            bottom: 0
        }

        90%,
        to {
            bottom: 13px
        }
    }

    .loading_circle_container_landscape,
    .loading_container_landscape,
    .loading_holder_landscape,
    .loading_panel_landscape {
        bottom: 0;
        left: 0;
        position: absolute;
        right: 0;
        top: 0
    }

    .loading_holder_landscape,
    .loading_panel_landscape {
        height: 360px
    }

    .loading_holder_landscape {
        max-width: 780px;
        min-width: 640px;
        z-index: 900
    }

    .loading_panel_landscape {
        top: 800px
    }

    .loading_background_landscape {
        height: 100%;
        width: 100%
    }

    .loading_container_landscape {
        margin: auto;
        text-align: center
    }

    .loading_circle_container_landscape {
        align-items: center;
        bottom: 34.7px;
        display: flex;
        height: 8.7px;
        justify-content: space-between;
        margin: auto;
        position: absolute;
        width: 20px
    }

    .loading_font_landscape {
        bottom: 0;
        color: #30a2d0;
        font-size: 12.7px;
        left: 0;
        line-height: 21.7px;
        margin: auto;
        max-height: 65px;
        padding-left: 7%;
        padding-right: 7%;
        position: absolute;
        right: 0;
        top: 52px;
        width: 86%
    }

    .loading_circle_container_center_landscape {
        bottom: 0
    }

    .loading_circle_landscape {
        animation-direction: alternate;
        animation-duration: .25s;
        animation-iteration-count: infinite;
        animation-name: loading_circle_bounce_landscape;
        animation-timing-function: ease-out;
        background-color: #30a2d0;
        border-radius: 50%;
        height: 4px;
        position: relative;
        width: 4px
    }

    .loading_circle_landscape:first-of-type {
        animation-delay: 0s
    }

    .loading_circle_landscape:nth-of-type(2) {
        animation-delay: -75ms
    }

    .loading_circle_landscape:nth-of-type(3) {
        animation-delay: -.15s
    }

    @keyframes loading_circle_bounce_landscape {
        0% {
            bottom: 0
        }

        90%,
        to {
            bottom: 7px
        }
    }

    #toast-container {
        left: 0;
        pointer-events: none;
        position: absolute;
        top: 0;
        visibility: visible;
        z-index: 950
    }

    #toast {
        background-color: #30303c;
        border-radius: 3.48px;
        box-shadow: 0 12px 18px 0 rgba(0, 0, 0, .4), inset 0 1px 0 0 hsla(0, 0%, 100%, .1);
        color: hsla(0, 0%, 100%, .9);
        display: inline-block;
        font-size: 14px;
        line-height: 18px;
        margin: auto;
        max-height: 676px;
        max-width: 300px;
        opacity: 0;
        padding: 18px;
        pointer-events: auto;
        position: absolute;
        text-align: center;
        visibility: hidden
    }

    #toast.toast_top {
        top: 20px
    }

    #toast.toast_bottom {
        bottom: 20px
    }

    #toast.toast_show {
        opacity: .96;
        visibility: visible
    }

    #toast.toast_hide {
        opacity: 0;
        transition: visibility 0s .3s, opacity .3s linear;
        visibility: hidden
    }

    #notification {
        background-color: #30303c;
        border-radius: 3.48px;
        color: hsla(0, 0%, 100%, .9);
        display: flex;
        display: inline-block;
        font-size: 14px;
        line-height: 18px;
        margin: auto;
        max-height: 676px;
        max-width: 300px;
        opacity: 0;
        padding: 18px;
        position: absolute;
        text-align: center;
        visibility: hidden
    }

    #notification.toast_top {
        top: 20px
    }

    #notification.toast_bottom {
        bottom: 20px
    }

    #notification.toast_show {
        opacity: 1;
        visibility: visible
    }

    #notification.toast_hide {
        opacity: 0;
        transition: visibility 0s .3s, opacity .3s linear;
        visibility: hidden
    }

    #notification-icon {
        background-color: #fff;
        border-radius: 3.48px;
        height: 44px;
        width: 44px
    }

    #notification-message {
        font-size: 14px;
        line-height: 18px;
        margin-left: 10px;
        text-align: left
    }


    .history .rcs-custom-scroll {
        min-height: 0;
        min-width: 0
    }

    .history .rcs-custom-scroll .rcs-outer-container {
        overflow: hidden
    }

    .history .rcs-custom-scroll .rcs-outer-container .rcs-positioning {
        position: relative;
        z-index: 99
    }

    .history .rcs-custom-scroll .rcs-outer-container:hover .rcs-custom-scrollbar {
        opacity: 1;
        transition-duration: .2s
    }

    .history.regular .rcs-custom-scroll .rcs-inner-container {
        -webkit-overflow-scrolling: touch;
        overflow-x: hidden;
        overflow-y: scroll
    }

    .history.mobile-horizontal .rcs-custom-scroll .rcs-inner-container {
        -webkit-overflow-scrolling: touch;
        overflow-y: scroll
    }

    .history .rcs-custom-scroll .rcs-inner-container:after {
        background-image: linear-gradient(180deg, rgba(0, 0, 0, .2), rgba(0, 0, 0, .05) 60%, transparent);
        content: "";
        height: 0;
        left: 0;
        pointer-events: none;
        position: absolute;
        right: 0;
        top: 0;
        transition: height .1s ease-in;
        will-change: height
    }

    .history .rcs-custom-scroll .rcs-inner-container.rcs-content-scrolled:after {
        height: 5px;
        transition: height .15s ease-out
    }

    .history .rcs-custom-scroll.rcs-scroll-handle-dragged .rcs-inner-container {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none
    }

    .history .rcs-custom-scroll .rcs-custom-scrollbar {
        box-sizing: border-box;
        height: 100%;
        opacity: 0;
        padding: 6px 0;
        pointer-events: none;
        position: absolute;
        right: 3px;
        transition: opacity .4s ease-out;
        width: 6px;
        will-change: opacity;
        z-index: 1
    }

    .history .rcs-custom-scroll .rcs-custom-scrollbar.rcs-custom-scrollbar-rtl {
        left: 3px;
        right: auto
    }

    .history .rcs-custom-scroll.rcs-scroll-handle-dragged .rcs-custom-scrollbar {
        opacity: 1
    }

    .history .rcs-custom-scroll .rcs-custom-scroll-handle {
        position: absolute;
        top: 0;
        width: 100%
    }

    .history .rcs-custom-scroll .rcs-inner-handle {
        background-color: hsla(0, 0%, 46%, .7);
        border-radius: 3px;
        height: calc(100% - 12px);
        margin-top: 6px
    }


    #calendar-selection-container {
        display: flex;
        flex-direction: column;
        font-size: 12px;
        height: 126px;
        position: absolute;
        top: 0;
        width: 360px
    }

    #calendar-view-container {
        height: 640px;
        position: absolute;
        top: 0;
        width: 360px;
        z-index: 3
    }

    #calendar-view-background {
        background-color: rgba(0, 0, 0, .6);
        font-size: 12px;
        height: 640px;
        position: absolute;
        width: 360px;
        z-index: 1
    }

    #calendar-view-container-horizontal {
        font-size: 20px;
        height: calc(100% - 10px);
        padding-left: 30px;
        width: calc(100% - 30px)
    }

    .calendar-line-separator {
        height: 1px;
        width: 100%
    }

    #custom-page-container {
        display: flex;
        flex-direction: column;
        font-size: 12px;
        height: 272px;
        position: absolute;
        top: 0;
        width: 360px
    }

    .calendar-item-container {
        align-items: center;
        display: flex;
        transition: opacity .1s ease-out
    }

    .calendar-item-container:active {
        opacity: .5
    }

    .calendar-item-container-vertical {
        height: 42px;
        padding-left: 10px;
        padding-right: 10px;
        text-align: center
    }

    .calendar-item-container-horizontal {
        height: 60px;
        text-align: left
    }

    .calendar-item-label {
        width: 100%
    }

    #calendar-custom-container {
        display: flex;
        flex-direction: row
    }

    #calendar-custom-view-container {
        height: 272px;
        position: relative;
        width: 360px
    }

    #calendar-arrow-image-container {
        align-items: center;
        display: flex;
        justify-content: center;
        padding-left: 10px
    }

    #calendar-arrow {
        transition: transform .15s ease-out
    }

    #calendar-view-container-horizontal-mobile {
        font-size: 14px;
        height: calc(100% - 10px);
        padding-left: 30px;
        width: 245px;
        z-index: 2
    }

    .calendar-item-container-horizontal-mobile {
        height: 36px;
        text-align: left
    }

    #calendar-view-background-horizontal-mobile {
        background-color: rgba(0, 0, 0, .7);
        font-size: 14px;
        height: 100%;
        left: 50px;
        position: absolute;
        top: 0;
        width: calc(100% - 50px);
        z-index: 2
    }


    #container-view {
        background-color: hsla(0, 0%, 100%, 0);
        color: hsla(0, 0%, 100%, .6);
        font-size: 14px;
        height: inherit;
        margin: 0 auto;
        position: relative;
        width: inherit
    }


    #error-container {
        align-items: center;
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: center;
        width: 100%
    }

    .error-container-vertical {
        font-size: 14px;
        line-height: 20px
    }

    .error-container-horizontal {
        font-size: 22px;
        line-height: 26px
    }

    #error-label {
        text-align: center;
        width: 80%
    }

    #error-retry-button-container {
        outline-style: solid;
        outline-width: thin;
        position: relative;
        transition: background-color .1s ease-out
    }

    #error-retry-button-container:active {
        opacity: .5
    }

    .error-retry-button-container-card {
        background-image: linear-gradient(180deg, #fbe96f 30%, #ffe196 50%, #df9b19 90%);
        outline-style: none !important
    }

    #error-retry-button-container-card-close,
    .error-retry-button-container-card {
        border-radius: 30px;
        position: relative;
        text-align: center;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, .3);
        transition: opacity .1s ease-out
    }

    #error-retry-button-container-card-close {
        background-image: linear-gradient(180deg, #9c9b99 30%, #908276 50%, #575554 90%);
        margin: 0;
        outline-style: none
    }

    #error-retry-button-container-card-close:active {
        opacity: .5
    }

    .error-retry-button-container-vertical {
        height: 32px;
        margin-top: 5%;
        width: 100px
    }

    .error-retry-button-container-horizontal {
        height: 64px;
        margin-top: 2%;
        width: 200px
    }

    #error-retry-button-label {
        position: absolute;
        text-align: center;
        white-space: nowrap
    }

    #error-close-button-label {
        text-decoration: underline;
        transition: opacity .1s ease-out
    }

    #error-close-button-label:active {
        opacity: .5
    }

    #error-game-title {
        margin: 0 auto;
        position: absolute;
        top: 0
    }


    #game-details-view-container {
        font-size: 14px;
        height: inherit;
        margin: 0 auto;
        position: relative;
        width: 100%;
        z-index: 1
    }

    #game-detail-view-navbar-container {
        position: relative;
        width: 100%;
        z-index: 4
    }

    #game-detail-spring-wrapper {
        width: inherit;
        transition: transform 0.5s ease;
    }

    #game-details-right-arrow {
        right: 10px;
    }

    #game-details-left-arrow {
        left: 10px;
        transition: transform 0.4s ease;
    }

    #game-details-page-container,
    .reset {
        position: relative
    }

    .reset {
        clear: both;
        height: inherit;
        width: inherit
    }

    #game-details-left-arrow,
    #game-details-right-arrow {
        align-items: center;
        border-radius: 50%;
        display: flex;
        height: 42px;
        justify-content: center;
        position: absolute;
        transform: translateZ(0);
        transition: opacity .1s ease-out;
        width: 42px;
        z-index: 2
    }

    #game-details-left-arrow:active,
    #game-details-right-arrow:active {
        opacity: .5
    }

    .game-detail-nav-label-container-horizontal {
        justify-content: center
    }

    #replay-buttons-container {
        align-items: center;
        bottom: 8px;
        display: flex;
        height: 64px;
        left: 50%;
        padding: 0 25px;
        position: absolute;
        transform: translate3d(-50%, 0, 1px);
        width: 310px;
        z-index: 3
    }

    .replay-icon-container {
        align-items: center;
        display: flex;
        height: 32px;
        justify-content: center;
        width: 32px
    }

    .replay-spin-label-wrapper {
        height: 32px;
        position: relative;
        width: 118px
    }

    .replay-spin-label {
        font-size: 12px;
        font-weight: 700;
        left: 50%;
        line-height: 32px;
        position: absolute;
        transform-origin: left center;
        white-space: nowrap
    }

    .replay-button-bg {
        border-radius: 16px;
        display: flex;
        height: 32px;
        width: 150px
    }

    .replay-button-bg:active {
        opacity: .5
    }

    .replay-icon-bg {
        align-items: center;
        background-color: #fff;
        border-radius: 50%;
        display: flex;
        height: 21px;
        justify-content: center;
        transition: opacity .1s ease-out;
        width: 21px
    }

    .replay-icon-triangle {
        border-style: solid;
        border-width: 5px 0 5px 8.7px;
        height: 0;
        transform: translateX(2px);
        width: 0
    }


    #game-free-spin-view-container {
        display: flex;
        flex-direction: column;
        font-size: 14px;
        height: inherit;
        position: absolute;
        top: 0;
        width: inherit
    }

    .game-free-spin-list-item {
        display: flex;
        height: 30px;
        padding: 10px;
        transition: background-color .1s ease-out
    }

    #game-free-spin-type {
        padding-left: 15px;
        padding-top: 5px
    }

    #game-free-spin-amount {
        margin-left: auto;
        margin-right: 0;
        padding-right: 15px;
        padding-top: 5px
    }

    #close-list-button {
        align-items: center;
        display: flex;
        height: 50px;
        justify-content: center;
        transition: opacity .1s ease-out;
        width: inherit
    }

    #close-list-button:active {
        opacity: .3
    }

    #nav-drop-down-arrow {
        transform: scale(.6) translateX(-5px)
    }


    .transition-transform-on {
        transition: transform .15s ease-out
    }

    .transition-width-on {
        transition: width .26s cubic-bezier(.19, 1, .22, 1)
    }

    .game-list-column-container {
        align-items: center;
        display: flex;
        flex-direction: column;
        height: inherit;
        justify-content: center
    }

    .game-list-view-container {
        height: inherit;
        margin: 0 auto;
        position: absolute;
        width: inherit
    }

    #game-list-view-navbar-container {
        position: relative;
        z-index: 2
    }

    #game-list-view-navbar-container-horizontal {
        box-shadow: 1px 0 4px 0 rgba(0, 0, 0, .3);
        position: relative;
        z-index: 2
    }

    #game-list-view-navbar-container-horizontal-mobile {
        display: flex;
        z-index: 5
    }

    #game-list-view-contents-container {
        height: inherit;
        position: relative;
        width: 100%;
        z-index: 1
    }

    #game-list-view-wrapper {
        display: flex;
        height: 100%;
        position: relative;
        width: 100%;
        z-index: 1
    }

    #game-list-detail-wrapper {
        display: block;
        height: inherit;
        overflow: hidden;
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 2
    }

    .game-list-detail-wrapper-h {
        box-shadow: 0 2px 10px 0 rgba(0, 0, 0, .5);
        height: 640px !important;
        width: 360px !important
    }

    #game-list-nav {
        display: flex;
        flex-direction: column;
        height: 100%;
        margin: 0 auto;
        width: 100%
    }

    .game-list-nav-horizontal {
        flex-direction: row
    }

    .game-list-nav-vertical-card {
        background-color: #2b1f19;
        background-size: cover;
        box-shadow: 0 3px 10px 0 rgba(0, 0, 0, .75);
        flex-direction: row
    }

    #game-list-nav-bar {
        display: flex;
        margin: 0 auto;
        position: relative
    }

    .game-list-nav-bar-vertical {
        flex-direction: row;
        height: calc(100% - 2px);
        width: 100%
    }

    .game-list-nav-bar-horizontal {
        flex-direction: column;
        height: 100%;
        width: calc(100% - 3px)
    }

    #game-title-wrapper {
        align-items: center;
        display: flex;
        position: relative
    }

    .game-title-wrapper-vertical {
        justify-content: center;
        line-height: 12px;
        min-height: 12px;
        padding-top: 4px;
        width: 200px
    }

    .game-title-wrapper-horizontal {
        justify-content: flex-start;
        line-height: 40px;
        min-height: 40px;
        padding-top: 14px;
        width: 200px
    }

    .game-title-wrapper-horizontal-navbar {
        justify-content: flex-start;
        line-height: 25px;
        min-height: 25px;
        width: 100%
    }

    #game-title-label {
        color: #a9a9ae;
        position: absolute;
        transform-origin: center center;
        white-space: nowrap
    }

    .game-title-label-vertical {
        left: 0;
        margin: auto;
        right: 0;
        text-align: center
    }

    .game-list-nav-image-container {
        align-items: center;
        display: flex;
        justify-content: center;
        transition: opacity .1s ease-out;
        width: 22.22%
    }

    .game-list-nav-image-container:active {
        opacity: .5
    }

    .game-list-nav-image-container-slot {
        height: inherit
    }

    .game-list-nav-image-container-card {
        height: 80%;
        justify-content: flex-start;
        padding-top: 3%
    }

    .game-list-nav-image-container-disabled {
        opacity: .5
    }

    #game-list-nav-image-right {
        justify-content: center
    }

    .game-list-nav-image-details-card {
        transform-origin: left
    }

    #game-list-nav-label-container {
        display: flex;
        flex-direction: column
    }

    .game-list-nav-label-container-vertical {
        align-items: center;
        height: 100%;
        justify-content: center;
        text-align: center;
        width: 55.55%
    }

    .game-list-nav-label-container-horizontal {
        align-items: flex-start;
        height: 100px;
        padding-left: 8%;
        padding-top: 76px;
        text-align: left
    }

    .game-list-nav-period-label {
        font-size: 14px
    }

    .game-list-nav-subtitle-label {
        font-size: 11px;
        line-height: 11px;
        margin-top: 2px
    }

    #game-free-spin-nav-label-wrapper {
        display: flex;
        height: 14px;
        line-height: 14px;
        position: relative
    }

    #game-free-spin-nav-label {
        font-size: 14px;
        position: absolute;
        transform-origin: left center;
        white-space: nowrap
    }

    #game-list-nav-table-header {
        align-items: center;
        display: flex;
        flex-direction: row;
        position: relative
    }

    .game-list-nav-table-header-vertical {
        font-size: 10px;
        height: 36px;
        padding-left: 20px;
        padding-right: 10px
    }

    .game-list-nav-table-header-vertical>div:first-child,
    .game-list-nav-table-header-vertical>div:nth-child(2) {
        width: 23%
    }

    .game-list-nav-table-header-vertical>div:nth-child(3) {
        justify-content: flex-end;
        width: 22%
    }

    .game-list-nav-table-header-vertical>div:nth-child(4) {
        justify-content: flex-end;
        width: 25%
    }

    .game-list-nav-table-header-horizontal {
        font-size: 20px;
        height: 84px;
        line-height: 24px;
        padding-left: 30px;
        padding-right: 5%
    }

    .game-list-nav-table-header-horizontal>div:first-child {
        width: 20%
    }

    .game-list-nav-table-header-horizontal>div:nth-child(2) {
        width: 30%
    }

    .game-list-nav-table-header-horizontal>div:nth-child(3),
    .game-list-nav-table-header-horizontal>div:nth-child(4) {
        justify-content: flex-end;
        width: 20%
    }

    #game-list-nav-table-item-container {
        display: flex;
        flex-direction: column;
        height: inherit;
        justify-content: space-evenly
    }

    .game-list-nav-table-item {
        display: flex;
        height: 18px
    }

    .game-list-nav-separator-vertical-slot {
        height: 2px;
        width: 100%
    }

    .game-list-nav-separator-vertical-card {
        height: 4px;
        width: 100%
    }

    .game-list-nav-separator-vertical-lobby {
        height: 1px;
        width: 100%
    }

    .game-list-nav-separator-horizontal {
        height: 100%;
        width: 1px
    }

    .game-list-nav-row-container {
        align-items: center;
        display: flex;
        flex-direction: row;
        height: 20px;
        justify-content: center
    }

    .game-list-item-container {
        align-items: center;
        display: flex;
        flex-direction: row;
        transition: background-color .2s ease-out
    }

    .game-list-item-container-lobby {
        height: 53px;
        margin-bottom: 1px
    }

    .game-list-item-container-card {
        background: #0e0c0c linear-gradient(0deg, #0f0d0d 80%, #191616)
    }

    .game-list-item-container-vertical {
        font-size: 10px;
        height: 54px;
        padding-left: 20px;
        padding-right: 10px
    }

    .game-list-item-container-vertical>div:first-child {
        width: 23%
    }

    .game-list-item-container-vertical>div:nth-child(2) {
        width: 24%
    }

    .game-list-item-container-vertical>div:nth-child(3) {
        justify-content: flex-end;
        margin-left: 11px;
        width: 18%
    }

    .game-list-item-container-vertical>div:nth-child(4) {
        justify-content: flex-end;
        margin-left: 15px;
        width: 20%
    }

    .game-list-item-container-vertical>div:nth-child(5) {
        width: 7%
    }

    .game-list-item-container-horizontal {
        font-size: 20px;
        height: 76px;
        line-height: 24px;
        padding-left: 30px;
        padding-right: 5%
    }

    .game-list-item-container-horizontal>div:first-child {
        width: 20%
    }

    .game-list-item-container-horizontal>div:nth-child(2) {
        width: 30%
    }

    .game-list-item-container-horizontal>div:nth-child(3),
    .game-list-item-container-horizontal>div:nth-child(4) {
        justify-content: flex-end;
        width: 20%
    }

    .game-list-item-container-horizontal>div:nth-child(5) {
        align-items: center;
        width: 10%
    }

    #game-list-item-arrow-image-container {
        align-items: center;
        display: flex;
        justify-content: center
    }

    .game-list-item-column-container {
        align-items: flex-start;
        display: flex;
        flex-direction: column;
        height: inherit;
        justify-content: center
    }

    .game-list-item-feature-container {
        display: flex;
        flex-direction: row;
        height: 14px;
        transform: scale(.291);
        transform-origin: left top
    }

    .game-list-item {
        display: flex
    }

    .game-list-item-image-container {
        padding-right: 5px
    }

    .game-list-item-collapse-info-label {
        font-size: 30px;
        line-height: 50px;
        transform-origin: left top;
        width: 30px
    }

    .game-list-item-collapse-info {
        background-color: rgba(0, 0, 0, .26);
        border-radius: 25px;
        display: flex;
        flex-direction: row;
        height: 50px;
        padding: 3px 0 2px 3px;
        transform: translateY(-3px)
    }

    #game-list-view-no-items-container {
        display: flex;
        flex-direction: column;
        justify-content: center
    }

    .game-list-view-no-item-label {
        padding-bottom: 5px;
        text-align: center
    }

    #game-list-footer-container {
        display: flex;
        flex-direction: row;
        font-size: 11px;
        line-height: 11px;
        z-index: 1
    }

    .game-list-footer-container-vertical {
        bottom: 0;
        padding-left: 20px;
        padding-right: 10px;
        position: absolute;
        width: calc(100% - 30px)
    }

    .game-list-footer-container-vertical>div:first-child {
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: center;
        text-align: left;
        width: 43%
    }

    .game-list-footer-container-vertical>div:nth-child(2),
    .game-list-footer-container-vertical>div:nth-child(3) {
        width: 25%
    }

    .game-list-footer-container-horizontal {
        height: 147px;
        padding-left: 30px;
        padding-right: 5%;
        position: relative
    }

    .game-list-footer-container-horizontal>div:first-child {
        text-align: left;
        width: 50%
    }

    .game-list-footer-container-horizontal>div:nth-child(2),
    .game-list-footer-container-horizontal>div:nth-child(3) {
        text-align: right;
        width: 20%
    }

    .game-list-footer-container-horizontal>div:nth-child(4) {
        text-align: right;
        width: 10%
    }

    #game-list-footer-date-container {
        position: relative
    }

    .game-list-footer-date-container-horizontal {
        display: flex;
        flex-direction: column;
        padding-top: 50px
    }

    #game-list-footer-date-vertical {
        display: flex;
        min-height: 25px;
        position: relative
    }

    #game-list-footer-date-label-vertical {
        line-height: 25px;
        position: absolute;
        transform-origin: left center;
        white-space: nowrap
    }

    .game-list-footer-date-label-horizontal {
        font-size: 30px;
        line-height: 33px;
        transform-origin: left center;
        transition: font-size .2s cubic-bezier(.19, 1, .22, 1);
        white-space: nowrap
    }

    #game-list-footer-record-vertical {
        display: flex;
        line-height: 25px;
        margin-top: -10px
    }

    .game-list-footer-record-horizontal {
        font-size: 20px;
        line-height: normal
    }

    .game-list-footer-item {
        height: 100%;
        position: relative
    }

    .game-list-footer-item-wrapper {
        margin-top: -5.5px;
        position: absolute;
        right: 0;
        text-align: end;
        top: 50%;
        transform-origin: right
    }

    #scroll-view {
        overflow: hidden;
        position: relative
    }

    #load-more-container {
        align-items: center;
        bottom: 0;
        display: flex;
        height: 80px;
        justify-content: center;
        position: absolute;
        width: inherit
    }

    #load-more-label {
        text-align: center;
        width: 100%
    }

    #game-list-touch-prevention {
        height: inherit;
        position: absolute;
        top: 0;
        width: inherit;
        z-index: 5
    }

    #game-banner-container {
        background-color: #fff;
        position: absolute;
        width: 100%
    }

    #game-banner-image {
        transform: translateY(-13%);
        width: 100%
    }

    #game-banner-tint {
        background-color: rgba(0, 0, 0, .6);
        left: 0;
        position: absolute;
        top: 0;
        width: 360px
    }

    #calendar-container {
        position: relative;
        z-index: 3
    }

    #game-list-scroll-view-container {
        height: 100%;
        width: 100%
    }

    #scroll-to-top-background {
        align-items: center;
        border-radius: 50%;
        box-shadow: 0 2px 8px 2px rgba(0, 0, 0, .3);
        display: flex;
        height: 60px;
        justify-content: center;
        left: 93%;
        position: absolute;
        top: 85%;
        transform: translateZ(0);
        -webkit-transform: translateZ(1px);
        width: 60px;
        z-index: 3
    }

    #scroll-to-top-background:active {
        opacity: .5
    }

    #game-list-nav-container-card {
        position: absolute;
        transform: translateY(-3px) scaleX(.3) scaleY(.45);
        transform-origin: top left
    }

    .gh-angle-vertical {
        border: solid #000;
        border-width: 0 1px 1px 0;
        display: inline-block;
        padding: 3px
    }

    .gh-angle-horizontal {
        border: solid #000;
        border-width: 0 2px 2px 0;
        display: inline-block;
        padding: 8px
    }

    .gh-angle-wrapper {
        align-items: center;
        display: flex;
        height: 30px;
        justify-content: center;
        transform: translateY(4px);
        width: 30px
    }

    .angle-right {
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg)
    }

    .angle-left {
        transform: rotate(135deg);
        -webkit-transform: rotate(135deg)
    }

    .angle-up {
        transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg)
    }

    .angle-down {
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg)
    }

    .gh-arrow {
        height: 2px;
        position: relative;
        width: 32px
    }

    .gh-arrow-right {
        transform: scale(-1)
    }

    .gh-arrow:after,
    .gh-arrow:before {
        background-color: inherit;
        content: "";
        height: 2px;
        position: absolute;
        width: 22px
    }

    .gh-arrow:after {
        right: 15px;
        top: 7px;
        transform: rotate(45deg)
    }

    .gh-arrow:before {
        right: 15px;
        top: -7px;
        transform: rotate(-45deg)
    }


    .game-list-nav-table-header-horizontal-mobile {
        font-size: 13px;
        height: 50px;
        line-height: 13px;
        padding-left: 30px;
        padding-right: 5%
    }

    .game-list-nav-table-header-horizontal-mobile>div:first-child {
        width: 20%
    }

    .game-list-nav-table-header-horizontal-mobile>div:nth-child(2) {
        width: 30%
    }

    .game-list-nav-table-header-horizontal-mobile>div:nth-child(3),
    .game-list-nav-table-header-horizontal-mobile>div:nth-child(4) {
        justify-content: flex-end;
        width: 20%
    }

    .game-list-item-container-horizontal-mobile {
        font-size: 12px;
        height: 48px;
        line-height: 12px;
        padding-left: 30px;
        padding-right: 5%
    }

    .game-list-item-container-horizontal-mobile>div:first-child {
        width: 20%
    }

    .game-list-item-container-horizontal-mobile>div:nth-child(2) {
        width: 30%
    }

    .game-list-item-container-horizontal-mobile>div:nth-child(3),
    .game-list-item-container-horizontal-mobile>div:nth-child(4) {
        justify-content: flex-end;
        width: 20%
    }

    .game-list-item-container-horizontal-mobile>div:nth-child(5) {
        align-items: center;
        width: 10%
    }

    .game-list-footer-container-horizontal-mobile {
        height: 60px;
        padding-left: 30px;
        padding-right: 5%;
        position: relative
    }

    .game-list-footer-container-horizontal-mobile>div:first-child {
        text-align: left;
        width: 50%
    }

    .game-list-footer-container-horizontal-mobile>div:nth-child(2),
    .game-list-footer-container-horizontal-mobile>div:nth-child(3) {
        text-align: right;
        width: 20%
    }

    .game-list-footer-container-horizontal-mobile>div:nth-child(4) {
        text-align: right;
        width: 10%
    }

    .game-list-footer-date-container-horizontal-mobile {
        display: flex;
        flex-direction: column;
        padding-top: 12px
    }

    .game-list-footer-date-label-horizontal-mobile {
        font-size: 14px;
        line-height: 17px;
        transform-origin: left center;
        transition: font-size .2s cubic-bezier(.19, 1, .22, 1);
        white-space: nowrap
    }

    .game-list-footer-record-horizontal-mobile {
        font-size: 12px;
        line-height: normal
    }

    #scroll-to-top-background-mobile {
        align-items: center;
        border-radius: 50%;
        box-shadow: 0 1px 4px 1px rgba(0, 0, 0, .3);
        display: flex;
        height: 40px;
        justify-content: center;
        left: 85%;
        position: absolute;
        top: 75%;
        transform: translateZ(0);
        -webkit-transform: translateZ(1px);
        width: 40px;
        z-index: 3
    }

    #scroll-to-top-background-mobile:active {
        opacity: .5
    }

    .gh-angle-horizontal-mobile {
        border: solid #000;
        border-width: 0 2px 2px 0;
        display: inline-block;
        padding: 4px
    }

    #side-bar-menu-container {
        display: flex;
        flex-direction: column;
        height: inherit;
        padding-top: 10px;
        width: 50px
    }

    .side-bar-menu-item {
        height: 50px;
        width: 50px
    }


    #loading-exit.vertical {
        height: 32px;
        position: absolute;
        right: 15px;
        top: 13px;
        width: 32px
    }

    #loading-exit.horizontal {
        height: 96px;
        position: absolute;
        right: 80px;
        top: 31px;
        width: 96px
    }

    .exit-icon {
        align-items: center;
        display: flex;
        justify-content: center
    }

    .exit-icon.vertical {
        height: 32px;
        width: 32px
    }

    .exit-icon.horizontal {
        height: 96px;
        width: 96px
    }

    .exit-icon-stroke {
        position: absolute
    }

    .exit-icon-stroke-vertical {
        height: 26px;
        width: 1px
    }

    .exit-icon-stroke-horizontal {
        height: 68px;
        width: 3px
    }

    .exit-icon-stroke-one {
        transform: rotate(45deg)
    }

    .exit-icon-stroke-two {
        transform: rotate(-45deg)
    }

    #loading-exit.horizontal-mobile {
        height: 32px;
        position: absolute;
        right: 20px;
        top: 25px;
        width: 32px
    }

    .exit-icon-stroke-horizontal-mobile {
        height: 26px;
        width: 1px
    }

    .exit-icon.horizontal-mobile {
        height: 32px;
        width: 32px
    }


    #lobby-summary-view-container {
        background-color: #f7f7f7;
        color: hsla(0, 0%, 100%, .6);
        font-size: 14px;
        height: inherit;
        margin: 0 auto;
        position: absolute;
        width: inherit
    }

    #lobby-summary-view-navbar {
        position: relative;
        z-index: 2
    }

    #lobby-summary-nav {
        background-color: #f7f7f7;
        flex-direction: column
    }

    #lobby-summary-nav,
    #lobby-summary-nav-bar {
        color: #000;
        display: flex;
        font-size: 14px;
        margin: 0 auto;
        position: relative;
        width: 100%
    }

    #lobby-summary-nav-bar {
        background-color: #fff;
        flex-direction: row;
        height: 62px;
        justify-content: space-between
    }

    #lobby-summary-nav-mid-label-container {
        align-items: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        line-height: 20px;
        padding-top: 10px;
        text-align: center
    }

    #lobby-summary-nav-history-label {
        font-size: 14px
    }

    #lobby-summary-nav-period-label {
        color: #8c8c8c;
        font-size: 11px
    }

    .lobby-summary-nav-image-container {
        align-items: center;
        display: flex;
        justify-content: center;
        padding-top: 10px;
        transition: opacity .1s ease-out;
        width: 80px
    }

    .lobby-summary-nav-image-container:active {
        opacity: .2
    }

    #lobby-summary-nav-image-container-left #lobby-summary-nav-image-container-right {
        align-items: center;
        display: flex;
        height: inherit;
        justify-content: center;
        width: inherit
    }

    #lobby-summary-nav-table-header {
        background-color: #fff;
        color: #000;
        display: flex;
        flex-direction: row;
        font-size: 14px;
        height: 49px;
        margin-bottom: 1px;
        padding-left: 18px;
        padding-right: 18px;
        position: relative
    }

    #lobby-summary-nav-table-header>div:first-child {
        width: 30%
    }

    #lobby-summary-nav-table-header>div:nth-child(2) {
        width: 20%
    }

    #lobby-summary-nav-table-header>div:nth-child(3),
    #lobby-summary-nav-table-header>div:nth-child(4) {
        justify-content: flex-end;
        width: 25%
    }

    .lobby-summary-nav-table-item {
        display: flex;
        font-size: 10px;
        line-height: 49px
    }

    #lobby-summary-item-container {
        background-color: #fff;
        color: #000;
        display: flex;
        flex-direction: row;
        font-size: 10px;
        height: 78px;
        margin: 1px auto 0;
        padding-left: 18px;
        padding-right: 18px;
        position: relative;
        transition: background-color .1s ease-out
    }

    #lobby-summary-item-container>div:first-child {
        width: 30%
    }

    #lobby-summary-item-container>div:nth-child(2) {
        width: 20%
    }

    #lobby-summary-item-container>div:nth-child(3),
    #lobby-summary-item-container>div:nth-child(4) {
        justify-content: flex-end;
        width: 25%
    }

    #lobby-summary-item-container:hover {
        background-color: #e6e6e6
    }

    #lobby-summary-item-container:active {
        background-color: #d3d3d3
    }

    .lobby-summary-item {
        align-items: center;
        display: flex;
        line-height: 49px
    }

    .lobby-summary-item-game-image {
        border-radius: 10px;
        box-shadow: -2px 2px 4px 1px rgba(0, 0, 0, .2);
        height: 44px;
        width: 44px
    }

    .lobby-default-game-icon-wrapper {
        transform: scale(.15);
        transform-origin: left top
    }

    #lobby-summary-list-view-container {
        background-color: #fff;
        color: #b6b6b6;
        font-size: 14px;
        height: 586px;
        position: relative;
        width: 100%
    }

    #lobby-summart-no-data-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        transform: translateY(50%)
    }

    #lobby-summary-no-data-image-container {
        height: 200px;
        transform: scale(.352)
    }

    #lobby-summary-no-data-label {
        text-align: center
    }


    .game-rules-ic_close {
        background-position: -216px 0;
        height: 108px;
        min-height: 108px;
        min-width: 108px;
        width: 108px
    }

    .game-rules-menu_close_button {
        background-position: -738px -108px;
        height: 72px;
        width: 72px
    }

    .game-rules-ic_nav_calender {
        background-position: -324px 0;
        height: 108px;
        min-height: 108px;
        min-width: 108px;
        vertical-align: middle;
        width: 108px
    }


    .paytable .rcs-custom-scroll,
    .paytable-land .rcs-custom-scroll,
    .rules .rcs-custom-scroll {
        min-height: 0;
        min-width: 0
    }

    .paytable .rcs-custom-scroll .rcs-outer-container,
    .paytable-land .rcs-custom-scroll .rcs-outer-container,
    .rules .rcs-custom-scroll .rcs-outer-container {
        overflow: hidden
    }

    .paytable .rcs-custom-scroll .rcs-outer-container .rcs-positioning,
    .rules .rcs-custom-scroll .rcs-outer-container .rcs-positioning {
        position: unset
    }

    .paytable .rcs-custom-scroll .rcs-outer-container:hover .rcs-custom-scrollbar,
    .paytable-land .rcs-custom-scroll .rcs-outer-container:hover .rcs-custom-scrollbar,
    .rules .rcs-custom-scroll .rcs-outer-container:hover .rcs-custom-scrollbar {
        opacity: 1;
        transition-duration: .2s
    }

    .paytable .rcs-custom-scroll .rcs-inner-container,
    .paytable-land .rcs-custom-scroll .rcs-inner-container,
    .rules .rcs-custom-scroll .rcs-inner-container {
        -webkit-overflow-scrolling: touch;
        overflow-x: hidden;
        overflow-y: scroll
    }

    .paytable .rcs-custom-scroll .rcs-inner-container:after,
    .paytable-land .rcs-custom-scroll .rcs-inner-container:after,
    .rules .rcs-custom-scroll .rcs-inner-container:after {
        background-image: linear-gradient(180deg, rgba(0, 0, 0, .2), rgba(0, 0, 0, .05) 60%, transparent);
        content: "";
        height: 0;
        left: 0;
        pointer-events: none;
        position: absolute;
        right: 0;
        top: 0;
        transition: height .1s ease-in;
        will-change: height
    }

    .paytable .rcs-custom-scroll .rcs-inner-container.rcs-content-scrolled:after,
    .paytable-land .rcs-custom-scroll .rcs-inner-container.rcs-content-scrolled:after,
    .rules .rcs-custom-scroll .rcs-inner-container.rcs-content-scrolled:after {
        height: 5px;
        transition: height .15s ease-out
    }

    .paytable .rcs-custom-scroll.rcs-scroll-handle-dragged .rcs-inner-container,
    .paytable-land .rcs-custom-scroll.rcs-scroll-handle-dragged .rcs-inner-container,
    .rules .rcs-custom-scroll.rcs-scroll-handle-dragged .rcs-inner-container {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none
    }

    .paytable .rcs-custom-scroll .rcs-custom-scrollbar,
    .paytable-land .rcs-custom-scroll .rcs-custom-scrollbar,
    .rules .rcs-custom-scroll .rcs-custom-scrollbar {
        box-sizing: border-box;
        height: 100%;
        opacity: 0;
        padding: 6px 0;
        pointer-events: none;
        position: absolute;
        right: 3px;
        transition: opacity .4s ease-out;
        width: 6px;
        will-change: opacity;
        z-index: 1
    }

    .paytable .rcs-custom-scroll .rcs-custom-scrollbar.rcs-custom-scrollbar-rtl,
    .paytable-land .rcs-custom-scroll .rcs-custom-scrollbar.rcs-custom-scrollbar-rtl,
    .rules .rcs-custom-scroll .rcs-custom-scrollbar.rcs-custom-scrollbar-rtl {
        left: 3px;
        right: auto
    }

    .paytable .rcs-custom-scroll.rcs-scroll-handle-dragged .rcs-custom-scrollbar,
    .paytable-land .rcs-custom-scroll.rcs-scroll-handle-dragged .rcs-custom-scrollbar,
    .rules .rcs-custom-scroll.rcs-scroll-handle-dragged .rcs-custom-scrollbar {
        opacity: 1
    }

    .paytable .rcs-custom-scroll .rcs-custom-scroll-handle,
    .paytable-land .rcs-custom-scroll .rcs-custom-scroll-handle,
    .rules .rcs-custom-scroll .rcs-custom-scroll-handle {
        position: absolute;
        top: 0;
        width: 100%
    }

    .paytable .rcs-custom-scroll .rcs-inner-handle,
    .paytable-land .rcs-custom-scroll .rcs-inner-handle,
    .rules .rcs-custom-scroll .rcs-inner-handle {
        background-color: hsla(0, 0%, 46%, .7);
        border-radius: 3px;
        height: calc(100% - 12px);
        margin-top: 6px
    }


    #login-container {
        left: 0;
        overflow: hidden;
        position: absolute;
        top: 0
    }

    #login {
        background-color: #000;
        color: #fff;
        height: 100%;
        position: absolute;
        top: 100vh;
        transition: top .3s linear;
        width: 100%
    }

    #login-body {
        background-color: #fff;
        width: 100%
    }

    #login-iframe {
        border-width: 0;
        height: 100%;
        width: 100%
    }

    #login-flex-container {
        align-items: stretch;
        align-items: flex-end;
        background-color: #000;
        display: flex
    }

    #login-flex-container>div {
        color: #fff;
        line-height: 54px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 100px
    }

    #login-header-left {
        flex-grow: 1;
        font-size: 11px;
        margin-left: 18px;
        text-align: left
    }

    #login-header-middle {
        flex-grow: 1;
        font-size: 14px;
        margin-left: 18px;
        margin-right: 18px;
        text-align: center
    }

    #login-header-right {
        flex-grow: 1;
        font-size: 11px;
        margin-right: 18px;
        text-align: right
    }


    .game-title {
        width: 300px;
        height: 17px;
        position: absolute;
        display: flex;
        color: white;
        opacity: 0.85;
        text-shadow: rgb(65, 50, 24) 1px 0px 0px, rgb(65, 50, 24) 0.552px 0.85px 0px, rgb(65, 50, 24) -0.4px 0.9px 0px,
            rgb(65, 50, 24) -0.1px 0.15px 0px, rgb(65, 50, 24) -0.65px -0.7px 0px, rgb(65, 50, 24) 0.3px -0.95px 0px, rgb(65,
                50, 24) 0.96px -0.28px 0px;
        pointer-events: none;
        white-space: nowrap;
        z-index: 250;
    }


    .time_stamp {
        height: 17px;
        position: absolute;
        display: flex;
        color: white;
        opacity: 0.85;
        text-shadow: rgb(65, 50, 24) 1px 0px 0px, rgb(65, 50, 24) 0.552px 0.85px 0px, rgb(65, 50, 24) -0.4px 0.9px 0px,
            rgb(65, 50, 24) -0.1px 0.15px 0px, rgb(65, 50, 24) -0.65px -0.7px 0px, rgb(65, 50, 24) 0.3px -0.95px 0px, rgb(65,
                50, 24) 0.96px -0.28px 0px;
        pointer-events: none;
        font-family: monospace;
        z-index: 250;
    }


    .blink_me {
        animation: blinker .25s linear 2
    }

    @keyframes blinker {
        0% {
            opacity: 1
        }

        25% {
            opacity: .5
        }

        50% {
            opacity: 0
        }

        75% {
            opacity: .5
        }

        to {
            opacity: 1
        }
    }


    .allscroll button[disabled] {
        pointer-events: none;
    }


    .TournamentLoadingViewBouncingBall {
        animation: bounce .24s;
        animation-direction: alternate;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in;
        background-color: #cdb780;
        border-radius: 50%;
        height: 6px;
        margin-right: 4px;
        width: 6px
    }

    .TournamentLoadingViewText {
        color: #cdb780;
        font-size: 14px;
        height: 14px;
        line-height: 20px;
        margin: 0
    }

    @keyframes bounce {
        0% {
            transform: translateZ(0)
        }

        to {
            transform: translate3d(0, 12px, 0)
        }
    }


    .mainPage-enter {
        top: 100%
    }

    .mainPage-enter.mainPage-enter-active {
        top: 0;
        transition: top 0ms linear
    }

    .mainPage-exit {
        top: 0
    }

    .mainPage-exit.mainPage-exit-active {
        top: 100%;
        transition: top 0ms linear
    }

    .slideIn-enter {
        left: 100%
    }

    .slideIn-enter.slideIn-enter-active {
        left: 0;
        transition: left 0ms linear
    }

    .slideIn-exit {
        left: 0
    }

    .slideIn-exit.slideIn-exit-active {
        left: -100%;
        transition: left 0ms linear
    }

    .slideOut-enter {
        left: -100%
    }

    .slideOut-enter.slideOut-enter-active {
        left: 0;
        transition: left 0ms linear
    }

    .slideOut-exit {
        left: 0
    }

    .slideOut-exit.slideOut-exit-active {
        left: 100%;
        transition: left 0ms linear
    }


    .CashTournament .rcs-custom-scroll .rcs-outer-container {
        overflow: hidden
    }

    .CashTournament .rcs-custom-scroll .rcs-inner-container {
        -webkit-overflow-scrolling: touch;
        overflow-x: hidden;
        overflow-y: scroll
    }

    .CashTournament .rcs-custom-scroll .rcs-custom-scrollbar {
        position: absolute;
        right: 0
    }


    .social_widget-container {
        float: right;
        height: inherit;
        margin-right: 4px;
        position: relative;
        width: 33px
    }

    .social_background-shadow {
        box-shadow: 29px 5px 20px 5px #000;
        position: absolute;
        width: 1px
    }

    .social_widget-partials-display-layout {
        height: 640px;
        pointer-events: none;
        position: absolute;
        visibility: inherit;
        width: 360px;
        z-index: 99
    }


    @keyframes common-button-scale-small {
        0% {
            transform: scale(.33);
            transform-origin: top left
        }

        to {
            transform: scale(.396) translate(-7px, -7px);
            transform-origin: top left
        }
    }

    @keyframes profile-button-scale {
        0% {
            transform: scale(.33) translateY(-6px);
            transform-origin: top left
        }

        to {
            transform: scale(.396) translate(-7px, -13px);
            transform-origin: top left
        }
    }

    @keyframes game-icon-button-scale {
        0% {
            transform: scale(1);
            transform-origin: top left
        }

        to {
            transform: scale(1.2) translate(-3px, -3px);
            transform-origin: top left
        }
    }

    @keyframes red-packet-button-scale {
        0% {
            transform: scale(1);
            transform-origin: top left
        }

        to {
            transform: scale(1.2) translate(-3px, -3px);
            transform-origin: top left
        }
    }

    @keyframes button-scale-big {
        0% {
            transform: scale(.33);
            transform-origin: top left
        }

        25% {
            transform: scale(.396) translate(-7px, -7px);
            transform-origin: top left
        }

        to {
            transform: scale(.594) translate(-21px, -21px);
            transform-origin: top left
        }
    }

    @keyframes star-fly {
        0% {
            opacity: 1;
            transform: scale(.495) translate(-14px, -14px)
        }

        to {
            opacity: 0;
            transform: scale(.495) translate(-14px, -120px)
        }
    }

    @keyframes replay-anim {
        0% {
            transform: scale(.33);
            transform-origin: top left
        }

        50% {
            transform: scale(.297) translate(3px, 3px);
            transform-origin: top left
        }

        to {
            transform: scale(.33);
            transform-origin: top left
        }
    }

    @keyframes replay-ripple-anim {
        0% {
            opacity: 1;
            transform: scale(.33);
            transform-origin: top left
        }

        50% {
            opacity: 1;
            transform: scale(.33);
            transform-origin: top left
        }

        to {
            opacity: 0;
            transform: scale(.528) translate(-19px, -19px);
            transform-origin: top left
        }
    }

    @keyframes frame-rotation {
        0% {
            transform: scale(.33) translate(-97px, -97px) rotate(0deg)
        }

        to {
            transform: scale(.33) translate(-97px, -97px) rotate(1turn)
        }
    }

    .social_widget-button {
        height: 33px;
        margin-bottom: 2px;
        position: relative;
        width: inherit
    }

    .social_replay-button {
        animation: replay-anim;
        animation-duration: 1.2s;
        animation-iteration-count: infinite;
        animation-timing-function: cubic-bezier(.37, 0, .63, 1)
    }

    .social_replay-ripple-effect {
        animation: replay-ripple-anim;
        animation-duration: 1.2s;
        animation-iteration-count: infinite;
        animation-timing-function: cubic-bezier(.37, 0, .63, 1)
    }

    .social_small-scale-button:active {
        animation: common-button-scale-small;
        animation-duration: .1s;
        animation-fill-mode: forwards
    }

    .social_big-scale-button:active {
        animation: button-scale-big;
        animation-duration: .2s;
        animation-fill-mode: forwards
    }

    .social_profile-button:active {
        animation: profile-button-scale;
        animation-duration: .1s;
        animation-fill-mode: forwards
    }

    .social_leaderboard-button:active {
        animation: game-icon-button-scale;
        animation-duration: .1s;
        animation-fill-mode: forwards
    }

    .social_red_packet_transition {
        transition: top .3s ease-out, left .3s ease-out
    }

    #social_game-icon-container:active {
        animation: game-icon-button-scale;
        animation-duration: .1s;
        animation-fill-mode: forwards
    }

    #social_red_packet_widget_container:active {
        animation: red-packet-button-scale;
        animation-duration: .1s;
        animation-fill-mode: forwards
    }

    .social_button-image {
        transform: scale(.33);
        transform-origin: top left
    }

    #social_red_packet_button-image {
        transform: scale(.11) translate(-250px, -100px);
        transform-origin: top left
    }

    #social_game-icon-placeholder {
        position: absolute;
        transform: scale(.165) translate(10px, 10px);
        transform-origin: top left
    }

    #social_game-icon {
        position: absolute;
        transform: scale(.35) translate(5px, 5px);
        transform-origin: top left
    }

    #social_game-icon-frame {
        animation: frame-rotation;
        animation-duration: 4s;
        animation-iteration-count: infinite;
        position: relative;
        transform: scale(.33) translate(-97px, -97px);
        transform-origin: center
    }

    #social_animated-fav-button {
        animation: star-fly;
        animation-delay: .25s;
        animation-duration: 1.2s;
        animation-fill-mode: forwards;
        pointer-events: none;
        transform: scale(.495) translate(-14px, -14px);
        transform-origin: top left
    }

    .social_notification-dot {
        background-color: red;
        border-radius: 50%;
        display: block;
        float: right;
        height: 18px;
        position: relative;
        right: 10px;
        top: 10px;
        width: 18px
    }


    .leaderboard_icon_img {
        background-image: url({{$gamePublicFolder}}/a14223fc-738f-42ef-8879-dde954c867d5.png);
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden
    }

    .default_profile_pic {
        background-position: -1px -1px;
        height: 252px;
        width: 252px
    }

    .ic_user_bronze {
        background-position: -255px -1px;
        height: 96px;
        width: 96px
    }

    .ic_user_gold {
        background-position: -255px -99px;
        height: 96px;
        width: 96px
    }

    .ic_user_silver {
        background-position: -353px -1px;
        height: 96px;
        width: 96px
    }


    .widget_icon_img {
        background-image: url({{$gamePublicFolder}}/91ffce2c-8842-4e66-a57f-ede4b605b559.png);
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden
    }

    .widget_icon_img.bg_dark_gradient {
        background-position: -1px -1px;
        height: 252px;
        width: 252px
    }

    .widget_icon_img.btn_favourite {
        background-position: -425px -1px;
        height: 96px;
        width: 96px
    }

    .widget_icon_img.btn_profile {
        background-position: -425px -99px;
        height: 96px;
        width: 96px
    }

    .widget_icon_img.ic_game_highlight {
        background-position: -621px -99px;
        height: 96px;
        width: 96px
    }

    .widget_icon_img.btn_replay {
        background-position: -523px -1px;
        height: 96px;
        width: 96px
    }

    .widget_icon_img.btn_share {
        background-position: -523px -99px;
        height: 96px;
        width: 96px
    }

    .widget_icon_img.btn_trophy {
        background-position: -621px -1px;
        height: 96px;
        width: 96px
    }

    .widget_icon_img.game_icon_placeholder {
        background-position: -255px -1px;
        height: 168px;
        width: 168px
    }


    .fav_icon_yellow {
        background-image: url({{$gamePublicFolder}}/download6.png);
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden
    }

    .fav_icon_yellow.btn_favourite {
        background-position: -1px -1px;
        height: 96px;
        width: 96px
    }


    .wallet-plugin-sprite {
        background-image: url({{$gamePublicFolder}}/3323e313-f83f-4293-8076-725a831ff8a7.png);
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden
    }

    .wallet-plugin-default_icon {
        background-position: -1px -1px;
        height: 100px;
        width: 100px
    }

    .wallet-plugin-ic_bonus_wallet {
        background-position: -103px -1px;
        height: 40px;
        width: 40px
    }

    .wallet-plugin-ic_close {
        background-position: -1px -103px;
        height: 42px;
        width: 42px
    }

    .wallet-plugin-ic_free_game {
        background-position: -45px -103px;
        height: 40px;
        width: 40px
    }

    .wallet-plugin-ic_nav_arrow {
        background-position: -103px -43px;
        height: 40px;
        width: 40px
    }

    .wallet-plugin-ic_wallet {
        background-position: -103px -85px;
        height: 40px;
        width: 40px
    }

    .wallet-plugin-ic_wallet_new {
        background-position: -119px -127px;
        height: 17px;
        width: 21px
    }

    .wallet-plugin-ic_warning_overlay {
        background-position: -87px -127px;
        height: 30px;
        width: 30px
    }


    .tournament_general_packed_2 {
        background-image: url({{$gamePublicFolder}}/888f58a8-89d5-459a-8f75-0b5f3428f912.png);
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden
    }

    .common_title_mini_colorblock_extend {
        background-position: -1px -1px;
        height: 102px;
        width: 1080px
    }

    .common_title_mini_colorblock_slim {
        background-position: -1px -105px;
        height: 66px;
        width: 1080px
    }


    .wallet-plugin-color-sprite {
        background-image: url({{$gamePublicFolder}}/download4.png);
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden
    }

    .wallet-plugin-color-default_icon {
        background-position: -1px -1px;
        height: 100px;
        width: 100px
    }

    .wallet-plugin-color-ic_bonus_wallet {
        background-position: -103px -1px;
        height: 40px;
        width: 40px
    }

    .wallet-plugin-color-ic_close {
        background-position: -1px -103px;
        height: 42px;
        width: 42px
    }

    .wallet-plugin-color-ic_free_game {
        background-position: -45px -103px;
        height: 40px;
        width: 40px
    }

    .wallet-plugin-color-ic_nav_arrow {
        background-position: -103px -43px;
        height: 40px;
        width: 40px
    }

    .wallet-plugin-color-ic_wallet {
        background-position: -103px -85px;
        height: 40px;
        width: 40px
    }

    .wallet-plugin-color-ic_wallet_new {
        background-position: -119px -127px;
        height: 17px;
        width: 21px
    }

    .wallet-plugin-color-ic_warning_overlay {
        background-position: -87px -127px;
        height: 30px;
        width: 30px
    }


    .tournament_lang_packed {
        background-image: url({{$gamePublicFolder}}/5a7e3dae-c04f-4b21-8d9a-cab90ce8ce23.png);
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden
    }

    .common_title_cash {
        background-position: -1px -1px;
        height: 102px;
        width: 450px
    }

    .common_title_cash_notime {
        background-position: -1px -313px;
        height: 102px;
        width: 390px
    }

    .common_title_global {
        background-position: -1px -105px;
        height: 102px;
        width: 450px
    }

    .common_title_global_notime {
        background-position: -1px -417px;
        height: 102px;
        width: 390px
    }

    .common_title_mini_cash {
        background-position: -153px -729px;
        height: 36px;
        width: 270px
    }

    .common_title_mini_global {
        background-position: -153px -767px;
        height: 36px;
        width: 270px
    }

    .common_title_mini_point {
        background-position: -153px -805px;
        height: 36px;
        width: 270px
    }

    .common_title_point {
        background-position: -1px -209px;
        height: 102px;
        width: 450px
    }

    .common_title_point_notime {
        background-position: -1px -521px;
        height: 102px;
        width: 390px
    }

    .common_title_tournament {
        background-position: -1px -625px;
        height: 102px;
        width: 390px
    }

    .window_point_icon_switchcash {
        background-position: -1px -729px;
        height: 78px;
        width: 150px
    }


    .tournament_general_packed {
        background-image: url({{$gamePublicFolder}}/f454f2b3-a075-46d5-b2be-5b42c4b406b3.png);
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden
    }

    .calculate_rank_cash_icon {
        background-position: -1073px -700px;
        height: 40px;
        width: 36px
    }

    .calculate_rank_global_icon {
        background-position: -1129px -770px;
        height: 40px;
        width: 36px
    }

    .calculate_rank_point_icon {
        background-position: -1131px -469px;
        height: 40px;
        width: 36px
    }

    .common_backtop_icon {
        background-position: -1107px -407px;
        height: 60px;
        width: 60px
    }

    .common_backtop_bg {
        background-position: -869px -393px;
        height: 156px;
        width: 156px
    }

    .common_icon14_backtop {
        background-position: -1135px -1px;
        height: 42px;
        width: 42px
    }

    .common_icon14_more {
        background-position: -1129px -289px;
        height: 42px;
        width: 42px
    }

    .common_icon14_location {
        background-position: -1135px -45px;
        height: 42px;
        width: 42px
    }

    .common_icon20_arrow {
        background-position: -1115px -540px;
        height: 60px;
        width: 60px
    }

    .common_icon20_close {
        background-position: -1115px -602px;
        height: 60px;
        width: 60px
    }

    .common_icon20_guide {
        background-position: -1115px -664px;
        height: 60px;
        width: 60px
    }

    .common_icon20_reset {
        background-position: -949px -637px;
        height: 60px;
        width: 60px
    }

    .common_icon20_history {
        background-position: -918px -897px;
        height: 60px;
        width: 60px
    }

    .common_icon20_home {
        background-position: -918px -959px;
        height: 60px;
        width: 60px
    }

    .common_icon20_openwindow {
        background-position: -788px -897px;
        height: 48px;
        width: 48px
    }

    .common_icon20_switch {
        background-position: -949px -699px;
        height: 60px;
        width: 60px
    }

    .common_icon20_switchwindow_l {
        background-position: -1011px -700px;
        height: 60px;
        width: 60px
    }

    .common_icon20_switchwindow_m {
        background-position: -949px -761px;
        height: 60px;
        width: 60px
    }

    .common_icon20_switchwindow_s {
        background-position: -1011px -762px;
        height: 60px;
        width: 60px
    }

    .common_icon_boy {
        background-position: -657px -1px;
        height: 390px;
        width: 390px
    }

    .common_icon_refresh_bg {
        background-position: -1px -927px;
        height: 90px;
        width: 180px
    }

    .common_rank_arrow_up {
        background-position: -657px -817px;
        height: 24px;
        width: 24px
    }

    .common_icon_refresh_icon {
        background-position: -1129px -89px;
        height: 48px;
        width: 48px
    }

    .common_rank_arrow_down {
        background-position: -1073px -798px;
        height: 24px;
        width: 24px
    }

    .details_icon_guide {
        background-position: -673px -947px;
        height: 72px;
        width: 72px
    }

    .details_icon_more {
        background-position: -747px -947px;
        height: 72px;
        width: 72px
    }

    .home_card_pic_multiday_cash_pglogo {
        background-position: -687px -897px;
        height: 48px;
        width: 99px
    }

    .tournament_home_common_bg_manydays-pg {
        background-position: -1027px -487px;
        height: 51px;
        width: 102px
    }

    .window_global_icon_switchwindow_l {
        background-position: -955px -551px;
        height: 78px;
        width: 78px
    }

    .common_tips_icon_time {
        background-position: -1142px -924px;
        height: 30px;
        width: 30px
    }

    .common_title_colorblock_left {
        background-position: -657px -393px;
        height: 210px;
        width: 210px
    }

    .common_title_colorblock_right {
        background-position: -657px -605px;
        height: 210px;
        width: 210px
    }

    .common_title_mini_colorblock {
        background-position: -1px -845px;
        height: 80px;
        width: 684px
    }

    .details_module_manygame_arrow_down {
        background-position: -1104px -924px;
        height: 36px;
        width: 36px
    }

    .common_titlebar_icon_back {
        background-position: -927px -823px;
        height: 60px;
        width: 60px
    }

    .common_titlebar_icon_close {
        background-position: -989px -824px;
        height: 60px;
        width: 60px
    }

    .common_titlebar_icon_filter {
        background-position: -980px -886px;
        height: 60px;
        width: 60px
    }

    .details_rank_icon_top1 {
        background-position: -980px -948px;
        height: 60px;
        width: 60px
    }

    .details_rank_icon_top3 {
        background-position: -1042px -886px;
        height: 60px;
        width: 60px
    }

    .details_rank_icon_top2 {
        background-position: -1051px -824px;
        height: 60px;
        width: 60px
    }

    .guide_icon_book {
        background-position: -1049px -1px;
        height: 84px;
        width: 84px
    }

    .guide_icon_cup {
        background-position: -869px -551px;
        height: 84px;
        width: 84px
    }

    .history_icon_bonus {
        background-position: -1129px -333px;
        height: 42px;
        width: 42px
    }

    .history_icon_freespin {
        background-position: -821px -977px;
        height: 42px;
        width: 42px
    }

    .history_icon_jackpot {
        background-position: -1129px -726px;
        height: 42px;
        width: 42px
    }

    .history_icon_gift {
        background-position: -865px -977px;
        height: 42px;
        width: 42px
    }

    .window_cash_icon_close {
        background-position: -353px -927px;
        height: 78px;
        width: 78px
    }

    .home_card_pic_multiday_cash_bg {
        background-position: -1px -1px;
        height: 420px;
        width: 654px
    }

    .pulldown_1_00043 {
        background-position: -183px -927px;
        height: 78px;
        width: 168px
    }

    .tournament_home_common_bg_manydays {
        background-position: -1px -423px;
        height: 420px;
        width: 654px
    }

    .window_cash_icon_menu_1 {
        background-position: -1049px -87px;
        height: 78px;
        width: 78px
    }

    .window_cash_icon_switchwindow_l {
        background-position: -433px -927px;
        height: 78px;
        width: 78px
    }

    .window_cash_icon_menu_2 {
        background-position: -869px -637px;
        height: 78px;
        width: 78px
    }

    .window_cash_icon_switchwindow_m {
        background-position: -1049px -167px;
        height: 78px;
        width: 78px
    }

    .window_cash_icon_switchwindow_s {
        background-position: -869px -717px;
        height: 78px;
        width: 78px
    }

    .window_global_icon_close {
        background-position: -513px -927px;
        height: 78px;
        width: 78px
    }

    .window_global_icon_menu_1 {
        background-position: -1049px -247px;
        height: 78px;
        width: 78px
    }

    .window_global_icon_switchwindow_m {
        background-position: -1049px -327px;
        height: 78px;
        width: 78px
    }

    .window_global_icon_menu_2 {
        background-position: -593px -927px;
        height: 78px;
        width: 78px
    }

    .window_global_icon_switchwindow_s {
        background-position: -1027px -407px;
        height: 78px;
        width: 78px
    }

    .window_point_icon_menu_1 {
        background-position: -687px -817px;
        height: 78px;
        width: 78px
    }

    .window_point_icon_close {
        background-position: -1035px -540px;
        height: 78px;
        width: 78px
    }

    .window_point_icon_menu_2 {
        background-position: -767px -817px;
        height: 78px;
        width: 78px
    }

    .window_point_icon_switchwindow_s {
        background-position: -1035px -620px;
        height: 78px;
        width: 78px
    }

    .window_rank_icon_top1 {
        background-position: -1129px -139px;
        height: 48px;
        width: 48px
    }

    .window_rank_icon_top2 {
        background-position: -1129px -189px;
        height: 48px;
        width: 48px
    }

    .window_switch_corner_highlight_point {
        background-position: -1113px -812px;
        height: 54px;
        width: 54px
    }

    .window_switch_corner_global {
        background-position: -1042px -948px;
        height: 54px;
        width: 54px
    }

    .window_point_icon_switchwindow_l {
        background-position: -847px -817px;
        height: 78px;
        width: 78px
    }

    .window_point_icon_switchwindow_m {
        background-position: -838px -897px;
        height: 78px;
        width: 78px
    }

    .window_rank_icon_top3 {
        background-position: -1129px -239px;
        height: 48px;
        width: 48px
    }

    .window_switch_corner_highlight_cash {
        background-position: -1073px -742px;
        height: 54px;
        width: 54px
    }

    .window_switch_corner_normal {
        background-position: -1113px -868px;
        height: 54px;
        width: 54px
    }


    .rangeslider {
        display: block;
        position: relative
    }

    .rangeslider-horizontal,
    .rangeslider__handle {
        height: 16px
    }

    .rangeslider__background {
        background-color: #fff;
        width: 100%
    }

    .rangeslider__background,
    .rangeslider__fill {
        height: 1.5px;
        position: absolute;
        top: 50%;
        touch-action: none
    }

    .rangeslider__fill {
        background-color: #1e88e5;
        display: block
    }

    .rangeslider__handle {
        background: #fff;
        background-clip: content-box;
        border-radius: 50%;
        box-shadow: 0 1px 1px transparent;
        display: inline-block;
        position: absolute;
        top: 54%;
        touch-action: none;
        transform: translate3d(-50%, -50%, 0);
        width: 16px
    }

    .rangeslider__handle:after {
        bottom: -16px;
        content: "";
        left: -16px;
        position: absolute;
        right: -16px;
        top: -16px
    }

    #slot-menu-container {
        color: #888;
        left: 0;
        overflow: hidden;
        position: absolute;
        text-align: center;
        top: 0
    }

    .ic_close {
        background-image: url({{$gamePublicFolder}}/49a9b6bc-c195-45d3-a57f-145608f312b9.png)
    }

    .menu_close_button {
        background-image: url({{$gamePublicFolder}}/c5eb171b-c7b1-4318-bd7c-6e73600b1fa8.png)
    }

    .slot_menu_scroller {
        content:"allscroll button[disabled]{pointer-events:none;}` "
    }


    .ic_chip {
        background-position: 37.414965986394556% 1.5873015873015872%
    }

    .ic_chip,
    .ic_coupon {
        background-image: url({{$gamePublicFolder}}/download7.png);
        background-size: 590% 205%;
        height: 60px;
        width: 60px
    }

    .ic_coupon {
        background-position: 37.414965986394556% 98.41269841269842%
    }

    .ic_free_game {
        background-position: 58.16326530612245% 1.5873015873015872%
    }

    .ic_free_game,
    .ic_rollover {
        background-image: url({{$gamePublicFolder}}/download5.png);
        background-size: 590% 205%;
        height: 60px;
        width: 60px
    }

    .ic_rollover {
        background-position: 58.16326530612245% 98.41269841269842%
    }

    .ic_spin {
        background-position: 78.91156462585035% 1.5873015873015872%
    }

    .ic_spin,
    .ic_wallet_open {
        background-image: url({{$gamePublicFolder}}/download3.png);
        background-size: 590% 205%;
        height: 60px;
        width: 60px
    }

    .ic_wallet_open {
        background-position: 78.91156462585035% 98.41269841269842%
    }

    .ic_win {
        background-position: 99.65986394557824% 1.5873015873015872%;
        background-size: 590% 205%;
        height: 60px;
        width: 60px
    }

    .ic_win,
    .menu_close_button {
        background-image: url({{$gamePublicFolder}}/download2.png)
    }

    .menu_close_button {
        background-position: 68.75% 68.75%;
        background-size: 322.22222222222223% 322.22222222222223%;
        height: 72px;
        width: 72px
    }


    .gh_common_sprite {
        background-image: url({{$gamePublicFolder}}/ca31c34e-78c0-47f9-9835-9644b7a59411.png);
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden
    }

    .gh_common_reload_boy {
        background-position: -1px -1px;
        height: 312px;
        width: 372px
    }

    .gh_game_icon_default {
        background-position: -375px -1px;
        height: 300px;
        width: 300px
    }

    .gh_ic_nav_back {
        background-position: -677px -1px;
        height: 108px;
        width: 108px
    }


    .gh_card_history_sprite {
        background-image: url({{$gamePublicFolder}}/f1823d30-b351-4bbd-9a8f-893bbeb321c6.png);
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden
    }

    .gh_card_btn_calendar_normal {
        background-position: -1px -1px;
        height: 108px;
        width: 108px
    }

    .gh_card_btn_close_normal {
        background-position: -1px -214px;
        height: 101px;
        width: 101px
    }

    .gh_card_ic_nav_back_default {
        background-position: -1px -111px;
        height: 101px;
        width: 106px
    }


    .gh_theme_sprite {
        background-image: url({{$gamePublicFolder}}/download1.png);
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden
    }

    .gh_ic_nav_bonus_game {
        background-position: -1px -1px;
        height: 48px;
        width: 48px
    }

    .gh_ic_nav_collapse {
        background-position: -51px -1px;
        height: 48px;
        width: 48px
    }

    .gh_ic_nav_free_spin {
        background-position: -101px -1px;
        height: 48px;
        width: 48px
    }

    .gh_ic_nav_freehand {
        background-position: -151px -1px;
        height: 48px;
        width: 48px
    }

    .gh_ic_nav_gift {
        background-position: -201px -1px;
        height: 48px;
        width: 48px
    }

    .gh_ic_nav_jackpot {
        background-position: -251px -1px;
        height: 48px;
        width: 48px
    }

    .gh_ic_nav_super6 {
        background-position: -301px -1px;
        height: 48px;
        width: 48px
    }


    .gh_basic_sprite {
        background-image: url({{$gamePublicFolder}}/25.png);
        background-repeat: no-repeat;
        background-size: 162px 112px;
        display: inline-block;
        overflow: hidden
    }

    .gh_ic_nav_calendar {
        background-position: -1px -1px;
        height: 110px;
        min-height: 110px;
        min-width: 110px;
        width: 110px
    }

    .gh_ic_nav_info_s {
        background-position: -113px -1px;
        height: 48px;
        min-height: 48px;
        min-width: 48px;
        width: 48px
    }


    .symbol_atlas {
        display: inline-block;
        overflow: hidden;
        background-repeat: no-repeat;
        background-image: url({{$gamePublicFolder}}/22.png)
    }

    .symbol_6 {
        background-position: -1px -1px
    }

    .symbol_1_1 {
        width: 120px;
        height: 120px;
        background-position: -1462px -1px
    }

    .symbol_6,
    .symbol_3 {
        width: 120px;
        height: 120px
    }

    .symbol_3 {
        background-position: -123px -1px
    }

    .symbol_2 {
        background-position: -245px -1px
    }

    .symbol_2,
    .symbol_7 {
        width: 120px;
        height: 120px
    }

    .symbol_7 {
        background-position: -367px -1px
    }

    .symbol_4 {
        background-position: -611px -1px
    }

    .symbol_5,
    .symbol_4 {
        width: 120px;
        height: 120px
    }

    .symbol_5 {
        background-position: -489px -1px
    }

    .symbol_12 {
        background-position: -733px -1px
    }

    .symbol_12,
    .symbol_8 {
        width: 120px;
        height: 120px
    }

    .symbol_8 {
        background-position: -977px -1px
    }

    .symbol_13 {
        background-position: -855px -1px
    }

    .symbol_13,
    .symbol_11 {
        width: 120px;
        height: 120px
    }

    .symbol_11 {
        background-position: -1099px -1px
    }

    .symbol_9 {
        background-position: -1221px -1px
    }

    .symbol_9,
    .symbol_10 {
        width: 120px;
        height: 120px
    }

    .symbol_10 {
        background-position: -1343px -1px
    }

    .symbol_1_plus1 {
        width: 120px;
        height: 120px;
        background-position: -1465px -1px
    }

    .symbol_0_plus1_travel {
        width: 120px;
        height: 120px;
        background-position: -1587px -1px
    }

    .wh {
        width: 120px;
        height: 120px;
        background-position: -1709px -1px
    }


    .special_symbol_atlas {
        display: inline-block;
        overflow: hidden;
        background-repeat: no-repeat;
        background-image: url({{$gamePublicFolder}}/24.png)
    }

    .symbol_1 {
        background-position: -1px -1px
    }

    .symbol_0_1 {
        background-position: -242px -1px
    }

    .symbol_1,
    .symbol_0 {
        width: 120px;
        height: 120px
    }

    .symbol_0 {
        background-position: -123px -1px
    }

    .symbol_0_scatter_travel {
        width: 120px;
        height: 120px;
        background-position: -245px -1px
    }


    .history_bg {
        display: inline-block;
        overflow: hidden;
        background-repeat: no-repeat;
        background-image: url({{$gamePublicFolder}}/23.png)
    }

    .bg_bns {
        background-position: -1px -1px
    }

    .bg_bns,
    .bg_main {
        width: 560px;
        height: 504px
    }

    .bg_main {
        background-position: -563px -1px
    }
</style>