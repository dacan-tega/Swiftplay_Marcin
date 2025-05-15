<head>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

</head>

<body>
    <div class="transaction">

        <div class="transaction__header">
            <img class="transaction__game-icon" src="{{$gamePublicFolder}}/logo.png">
            <span class="transaction__title">bonusjoker</span>
            <span class="transaction__title transaction__title--second">History details</span>
        </div>

        <div id="game-pages-window">


        </div>
    </div>
    <script>
        const id = '{{$id}}';
        const apiUrl = '{{$api_url}}';
        const token = '{{$token}}';
        const gameName = '{{$gameName}}';
        const gamePublicFolder = '{{$gamePublicFolder}}';
        var postData = {
            "action": "history_detail",
            "id": id
        };
        console.log("id", id);
        console.log("apiUrl", apiUrl);
        console.log("token", token);
        console.log("gameName", gameName);
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
                    var items = data.data;
                    console.log("items", items);
                    var freeMode = false;
                    var title = "";
                    var betInformation = "";
                    var transactionItem = "";
                    var listPage = "";
                    var spin = "";
                    var slideCss = 0;
                    var listPageEl = $('#game-pages-window');

                    var summarty = `
                                <div class="transaction__card">

                                    <div class="transaction__data transaction__data--title">
                                        Session summary:
                                    </div>
                                    <div class="transaction__info">

                                        <div class="transaction__data transaction__data--shield transaction__data--session transaction__data--id">
                                            <span class="transaction__label transaction__label--shield">Identifier:</span>
                                            <span class="transaction__value transaction__value--shield">${items[0].id}</span>
                                        </div>

                                        <div class="transaction__data transaction__data--shield transaction__data--session">
                                            <span class="transaction__label transaction__label--shield">Date:</span>
                                            <span class="transaction__value transaction__value--shield">${items[0].date}</span>
                                        </div>

                                        <div class="transaction__data transaction__data--shield transaction__data--session">
                                            <span class="transaction__label transaction__label--shield">Balance:</span>
                                            <span class="transaction__value transaction__value--shield">€${items[0].balance}</span>
                                        </div>

                                        <div class="transaction__data transaction__data--shield transaction__data--session">
                                            <span class="transaction__label transaction__label--shield">Bet:</span>
                                            <span class="transaction__value transaction__value--shield">€${items[0].bet}</span>
                                        </div>

                                        <div class="transaction__data transaction__data--shield transaction__data--session">
                                            <span class="transaction__label transaction__label--shield">Win:</span>
                                            <span class="transaction__value transaction__value--shield">€${items[0].win}</span>
                                        </div>
                                    </div>
                                </div>`;
                    for (let i = 0; i < items.length; i++) {
                        var item = items[i];
                        var countItem = item.length;
                        var countFreeSpin = item.length - 1;
                        var date = item['date'];
                        var symbols = item['symbols'];
                        // var hour = item[countFreeSpin]['spin_hour'];
                        // var freeMode = item[countFreeSpin]['free_spin'];
                        // var betSize = item[countFreeSpin]['bet_level'];
                        // var credit = item[countFreeSpin]['credit'];
                        // var winTotal = item[countFreeSpin]['win_total'];
                        // var winMulti = item[countFreeSpin]['win_multi'];
                        // var betLevel = item[countFreeSpin]['bet_size'];
                        // var titleSpin = freeMode ? "Free Spin" : "Normal Spin";
                        // var numberFreeSpin = item[countFreeSpin]['free_num'];
                        // var transaction = item[countFreeSpin]['transaction'];
                        // var freeNum = item[countFreeSpin]['free_num']
                        // var countScatter = item[countFreeSpin]['count_scatter'];
                        // var freeSpinMore = item[countFreeSpin]['freespin_more'];
                        // var freeSpin = item[countFreeSpin]['free_num'];
                        // var multiplyDrop = item[countFreeSpin]['mutilply'];
                        var winDropArr = item.winLines;
                        var newReel = item.new_reel;
                        var winresult = "";
                        var winnNingLines = "";
                        for (let j = 0; j < winDropArr.length; j++) {
                            winnNingLines = `<div class="transaction__data transaction__data--title">
                                                Winning lines:
                                            </div>
                                            `;
                            var winDrop = winDropArr[j];
                            var activeIcon = winDrop.active_icon;
                            var symbolsWin = winDrop.symbols;
                            console.log("activeIcon", activeIcon);
                            var lineResult = "";
                            for (let d = 0; d < newReel[0].length; d++) {
                                for (let e = 0; e < newReel.length; e++) {
                                    var check = e * newReel[e].length + (newReel[e].length - d) - 1;
                                    if (activeIcon.includes(check)) {
                                        if (check > 2) {
                                            lineResult = lineResult + `
                                            <div class="pattern__dot   pattern__dot--filled"></div>
                                            `;

                                        } else {
                                            lineResult = lineResult + `
                                            <div class="pattern__dot  pattern__dot--left pattern__dot--filled"></div>
                                            `;
                                        }
                                    } else {
                                        lineResult = lineResult + `
                                        <div class="pattern__dot   "></div>
                                        `;
                                    }
                                }
                            }
                            var symbolWinResult = "";
                            for (let d = 0; d < symbolsWin.length; d++) { 
                                symbolWinResult = symbolWinResult + `
                                <img class="field__symbol"
                                src="${gamePublicFolder}/${symbolsWin[d]}.png"
                                alt="8" srcset="">
                                `;
                            }
                            console.log(111233);
                            winresult = winresult + `
                                <div class="transaction__entry">
                                                <div class="transaction__line-info">

                                                    <div class="transaction__data transaction__data--shield ">
                                                        <span class="transaction__label transaction__label--shield">Identifier:</span>
                                                        <span class="transaction__value transaction__value--shield">${winDrop.id}</span>
                                                    </div>


                                                    <div class="transaction__data transaction__data--shield ">
                                                        <span class="transaction__label transaction__label--shield">Free spins:</span>
                                                        <span class="transaction__value transaction__value--shield">${item.freeSpins}</span>
                                                    </div>

                                                    <div class="transaction__data transaction__data--shield ">
                                                        <span class="transaction__label transaction__label--shield">Win:</span>
                                                        <span class="transaction__value transaction__value--shield">€${winDrop.amount}</span>
                                                    </div>
                                                </div>
                                                <div class="transaction__field">

                                                    <div class="pattern" style="grid-template-columns: repeat(3, 1fr)">
                                                        ` + lineResult + `
                                                    </div>


                                                    <div class="field field--lines" style="grid-template-columns: repeat(3, 1fr)">
                                                        ` + symbolWinResult + `
                                                    </div>
                                                </div>

                                            </div>
                                `;
                        } 
                        var noWin = "";
                        console.log("winDropArr.length", winDropArr.length);
                        if (winDropArr.length == 0) {
                            noWin = `<div class="transaction__data transaction__data--no-comb">No winning combinations</div>`;
                        }
                        console.log("item", item);
                        var resultSymbol = "";
                        for (let j = 0; j < symbols.length; j++) {
                            var symbol = symbols[j];
                            if (symbol != "_blank" && symbol.includes(":")) {
                                symbolArr = symbol.split(":");
                                symbol = symbolArr[0];
                            }
                            resultSymbol = resultSymbol + `
                                <img class="field__symbol" src="${gamePublicFolder}/${symbol}.png" alt="1" srcset="">
                            `;
                        }
                        spin = spin + `
                                <div class="transaction__card">

                                    <div class="transaction__data transaction__data--title">
                                        Game event - Spin:
                                    </div>

                                    <div class="transaction__data transaction__data--id-date">
                                        <span class="transaction__label">Identifier: ${item.id}</span>
                                        <span class="transaction__label">Date: ${item.date}</span>
                                    </div>



                                    <div class="transaction__data">

                                        <div class="field " style="grid-template-columns: repeat(3, 1fr)">
                                            ` + resultSymbol + `
                                        </div>
                                    </div>

                                    <div class="transaction__info">




                                        <div class="transaction__data transaction__data--shield ">
                                            <span class="transaction__label transaction__label--shield">Bet:</span>
                                            <span class="transaction__value transaction__value--shield">€${item.bet}</span>
                                        </div>

                                        <div class="transaction__data transaction__data--shield ">
                                            <span class="transaction__label transaction__label--shield">Win:</span>
                                            <span class="transaction__value transaction__value--shield">€${item.win}</span>
                                        </div>

                                    </div>



                                    <div class="transaction__data transaction__data--title">
                                        Feature:
                                    </div>
                                    <div class="transaction__data">
                                        <div class="feature">
                                            <div class="feature__info feature__info--text">

                                                <div class="feature__data">
                                                    <span class="feature__title">Name:</span>
                                                    <span class="feature__value">${item.type}</span>
                                                </div>




                                                <div class="feature__data">
                                                    <span class="feature__title">Free spins:</span>
                                                    <span class="feature__value">${item.freeSpins}</span>
                                                </div>


                                            </div>


                                        </div>
                                    </div>

                                    ` + winnNingLines + `

                                    
                                    <div class="transaction__data">

                                        

                                        ` + winresult + `

                                    </div>
                                    ` + noWin + `

                                </div>`;
                        console.log(999);
                        slideCss = slideCss + 360;
                        // listPage = listPage + page;
                        // var page = $(` ${summarty}
                        // `);
                        // console.log("page", page);




                    }
                    var page = $(` ${summarty} + ${spin}
                            `);
                    listPageEl.append(page);

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
                // var href = $(this).attr("href", apiUrl+"/history?token="+token);
                var href = apiUrl + "/history?token=" + token;
                window.location.href = href
                // alert("The paragraph was clicked.");
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
    @font-face {
        font-family: Roboto;
        font-style: normal;
        font-weight: 400;
        src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v16/ek4gzZ-GeXAPcSbHtCeQI_esZW2xOQ-xsNqO47m55DA.woff2) format("woff2");
        unicode-range: U+0460-052f, U+20b4, U+2de0-2dff, U+a640-a69f
    }

    @font-face {
        font-family: Roboto;
        font-style: normal;
        font-weight: 400;
        src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v16/mErvLBYg_cXG3rLvUsKT_fesZW2xOQ-xsNqO47m55DA.woff2) format("woff2");
        unicode-range: U+0400-045f, U+0490-0491, U+04b0-04b1, U+2116
    }

    @font-face {
        font-family: Roboto;
        font-style: normal;
        font-weight: 400;
        src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v16/-2n2p-_Y08sg57CNWQfKNvesZW2xOQ-xsNqO47m55DA.woff2) format("woff2");
        unicode-range: U+1f??
    }

    @font-face {
        font-family: Roboto;
        font-style: normal;
        font-weight: 400;
        src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v16/u0TOpm082MNkS5K0Q4rhqvesZW2xOQ-xsNqO47m55DA.woff2) format("woff2");
        unicode-range: U+0370-03ff
    }

    @font-face {
        font-family: Roboto;
        font-style: normal;
        font-weight: 400;
        src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v16/NdF9MtnOpLzo-noMoG0miPesZW2xOQ-xsNqO47m55DA.woff2) format("woff2");
        unicode-range: U+0102-0103, U+1ea0-1ef9, U+20ab
    }

    @font-face {
        font-family: Roboto;
        font-style: normal;
        font-weight: 400;
        src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v16/Fcx7Wwv8OzT71A3E1XOAjvesZW2xOQ-xsNqO47m55DA.woff2) format("woff2");
        unicode-range: U+0100-024f, U+1e??, U+20a0-20ab, U+20ad-20cf, U+2c60-2c7f, U+a720-a7ff
    }

    @font-face {
        font-family: Roboto;
        font-style: normal;
        font-weight: 400;
        src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v16/CWB0XYA8bzo0kSThX0UTuA.woff2) format("woff2");
        unicode-range: U+00??, U+0131, U+0152-0153, U+02c6, U+02da, U+02dc, U+2000-206f, U+2074, U+20ac, U+2212, U+2215
    }

    a,
    address,
    article,
    aside,
    audio,
    b,
    big,
    blockquote,
    body,
    canvas,
    caption,
    code,
    dd,
    del,
    details,
    dfn,
    div,
    dl,
    dt,
    em,
    embed,
    fieldset,
    figcaption,
    figure,
    footer,
    form,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    header,
    hgroup,
    html,
    i,
    iframe,
    img,
    label,
    legend,
    li,
    main,
    mark,
    menu,
    nav,
    ol,
    output,
    p,
    pre,
    q,
    s,
    samp,
    section,
    small,
    span,
    strong,
    sub,
    summary,
    sup,
    table,
    tbody,
    td,
    tfoot,
    th,
    thead,
    time,
    tr,
    tt,
    u,
    ul,
    var,
    video {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        font: inherit;
        vertical-align: baseline
    }

    article,
    aside,
    details,
    figcaption,
    figure,
    footer,
    header,
    hgroup,
    menu,
    nav,
    section {
        display: block;
        margin: 0
    }

    ol,
    ul {
        list-style: none
    }

    table {
        border-collapse: collapse;
        border-spacing: 0
    }

    body {
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
        text-align: center;
        line-height: 1.15
    }

    h1 {
        font-size: 2em;
        margin: .67em 0
    }

    a {
        background-color: transparent;
        -webkit-text-decoration-skip: objects
    }

    b,
    strong {
        font-weight: bolder
    }

    small {
        font-size: 80%
    }

    figure {
        margin: 1em 40px
    }

    img {
        border-style: none
    }

    [type=button],
    [type=reset],
    [type=submit],
    button {
        cursor: pointer
    }

    button::-moz-focus-inner,
    input::-moz-focus-inner {
        border: 0;
        padding: 0
    }

    textarea {
        overflow: auto
    }

    [hidden] {
        display: none !important
    }

    [clear] {
        clear: both
    }

    ::-moz-selection {
        background: #b3d4fc;
        text-shadow: none
    }

    ::selection {
        background: #b3d4fc;
        text-shadow: none
    }

    *,
    :after,
    :before {
        box-sizing: border-box
    }

    hr {
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid #ccc;
        margin: 1em 0;
        padding: 0
    }

    :root {
        --main-bg-color: #fff
    }

    section {
        background: #fff
    }

    main h1 {
        font-family: Roboto, sans-serif
    }

    header {
        display: inline-block;
        width: 100%;
        background: #000
    }

    header nav {
        float: right
    }

    header nav li {
        float: left;
        margin-left: 10px
    }

    section.example {
        width: 100%
    }

    .example .cards {
        display: inline-block;
        margin-bottom: -4px
    }

    .example article {
        float: left
    }

    footer {
        display: block;
        width: 100%
    }

    @media print {

        *,
        :after,
        :before,
        :first-letter,
        :first-line {
            background: transparent !important;
            color: #000 !important;
            box-shadow: none !important;
            text-shadow: none !important
        }

        a,
        a:visited {
            text-decoration: underline
        }

        a[href]:after {
            content: " (" attr(href) ")"
        }

        abbr[title]:after {
            content: " (" attr(title) ")"
        }

        a[href^="#"]:after,
        a[href^="javascript:"]:after {
            content: ""
        }

        blockquote,
        pre {
            border: 1px solid #999
        }

        blockquote,
        img,
        pre {
            page-break-inside: avoid
        }

        img {
            max-width: 100% !important
        }

        h2,
        h3,
        p {
            orphans: 3;
            widows: 3
        }

        h2,
        h3 {
            page-break-after: avoid
        }
    }

    .field {
        background-color: #111;
        border-radius: 5px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        padding: 5px 10px;
        grid-gap: 5px;
        overflow: hidden
    }

    @media(min-width: 811px) {
        .field {
            padding: 15px 25px;
            grid-gap: 10px
        }
    }

    .field--awp-line {
        padding: 5px 70px;
        grid-template-columns: none !important
    }

    @media(min-width: 811px) {
        .field--awp-line {
            padding: 10px
        }
    }

    .field__symbol {
        max-width: 100%;
        max-height: 100%;
        color: #fff;
        text-transform: uppercase;
        text-align: center;
        line-height: 3rem
    }

    .field__symbol--empty {
        position: relative
    }

    .field__symbol--empty:after,
    .field__symbol--empty:before {
        content: "";
        display: block;
        width: 30%;
        height: 6%;
        background: #1c2939;
        position: absolute;
        top: 50%;
        justify-items: legacy;
        left: 50%;
        transform: translate(-50%, -50%) rotate(45deg)
    }

    .field__symbol--empty:after {
        transform: translate(-50%, -50%) rotate(-45deg)
    }

    .pattern {
        width: auto;
        max-width: 150px;
        background: #000;
        display: grid;
        grid-row-gap: 4px;
        grid-column-gap: 4px;
        justify-content: center;
        align-content: center;
        padding: 5px
    }

    .pattern__dot {
        padding-top: 100%;
        background: grey;
        border-radius: 25%
    }

    .pattern__dot--filled {
        background: red
    }

    .pattern__dot--left,
    .pattern__dot--right {
        position: relative
    }

    .pattern__dot--left:before,
    .pattern__dot--right:before {
        display: block;
        position: absolute;
        content: "";
        border-style: solid;
        top: 50%;
        left: 50%
    }

    .pattern__dot--left:before {
        border-color: transparent transparent transparent #d3d3d3;
        border-width: 4px 0 4px 7px;
        transform: translate(-50%, -50%)
    }

    @media(min-width: 811px) {
        .pattern__dot--left:before {
            border-width: 8px 0 8px 10px;
            transform: translate(calc(-50% + 1px), -50%)
        }
    }

    .pattern__dot--right:before {
        border-color: transparent #d3d3d3 transparent transparent;
        border-width: 4px 7px 4px 0;
        transform: translate(calc(-50% - 2px), -50%)
    }

    @media(min-width: 811px) {
        .pattern__dot--right:before {
            border-width: 8px 10px 8px 0;
            transform: translate(calc(-50% - 1px), -50%)
        }
    }

    .feature {
        display: grid;
        padding: 10px 0;
        border-radius: 5px;
        grid-column-gap: 0;
        -moz-column-gap: 0;
        column-gap: 0
    }

    @media(min-width: 811px) {
        .feature {
            grid-template-columns: repeat(2, 1fr);
            grid-column-gap: 10px;
            -moz-column-gap: 10px;
            column-gap: 10px
        }
    }

    .feature--gamble {
        background: #16202b;
        padding-left: 10px;
        padding-right: 10px
    }

    .feature--gamble-deck {
        background: #16202b;
        grid-template-columns: unset;
        grid-auto-flow: column;
        grid-auto-columns: 1fr;
        align-items: end
    }

    .feature__info {
        display: grid;
        grid-row-gap: 5px;
        row-gap: 5px
    }

    .feature__info--text {
        grid-column: 1/3;
        grid-template-columns: repeat(auto-fit, minmax(1px, 1fr));
        grid-column-gap: 5px;
        -moz-column-gap: 5px;
        column-gap: 5px
    }

    .feature__data {
        background: #253548;
        padding: 10px 15px;
        display: grid;
        align-content: center;
        align-items: center;
        border-radius: 5px;
        grid-template-columns: -webkit-max-content 1fr;
        grid-template-columns: max-content 1fr;
        grid-column-gap: 15px;
        -moz-column-gap: 15px;
        column-gap: 15px
    }

    .feature__title {
        color: #888
    }

    .feature__value {
        color: #ddd
    }

    .feature__pick {
        text-align: center;
        padding: 5px;
        border-radius: 5px;
        color: #ddd;
        display: grid;
        justify-content: center;
        grid-row-gap: 15px;
        row-gap: 15px
    }

    .feature__pick--deck {
        padding: 0
    }

    @media(min-width: 811px) {
        .feature__pick {
            padding: 10px
        }
    }

    .feature__pick--player {
        background-color: #16202b
    }

    .feature__pick--server {
        background-color: #253548
    }

    .feature__pick-icon {
        margin: 0 auto;
        width: 50%
    }

    .feature__pick-icon--deck {
        width: 100%
    }

    @media(min-width: 811px) {
        .feature__pick-icon {
            width: 100%
        }
    }

    .feature__options {
        background: #16202b;
        grid-column: 1/3;
        border-radius: 5px;
        margin-top: 10px;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-gap: 5px;
        gap: 5px;
        padding: 5px;
        justify-items: center;
        align-items: center
    }

    .feature__option {
        border-radius: 5px;
        color: grey;
        background: #253548;
        width: 100%;
        padding: 10px;
        text-align: center;
        align-self: stretch;
        justify-self: stretch;
        place-self: stretch
    }

    .feature__option--selected {
        color: #fff
    }

    html {
        font-size: 16px
    }

    body {
        background-color: #111821
    }

    .transaction {
        padding: 10px 5px
    }

    @media(min-width: 1024px) {
        .transaction {
            max-width: 1024px;
            margin: 0 auto
        }
    }

    @media(min-width: 375px) {
        .transaction {
            padding: 10px
        }
    }

    .transaction--embeded {
        position: absolute;
        width: 100vw;
        height: 100vh;
        top: 0;
        left: 0
    }

    .transaction__header {
        display: grid;
        align-items: self-start;
        grid-template: "logo type" "logo game";
        margin: 20px 0;
        grid-template-columns: -webkit-min-content -webkit-min-content;
        grid-template-columns: min-content min-content;
        white-space: nowrap;
        align-items: center;
        text-align: left;
        grid-column-gap: 10px;
        -moz-column-gap: 10px;
        column-gap: 10px
    }

    .transaction__title {
        color: #ddd;
        font-size: 1.25rem
    }

    .transaction__title--second {
        color: #888;
        font-size: 1rem
    }

    .transaction__game-icon {
        max-width: 90px;
        grid-area: logo
    }

    .transaction__card {
        background: #1c2939;
        border-radius: 10px;
        margin: 15px auto 5px;
        padding: 10px;
        text-align: left
    }

    .transaction__info {
        display: grid;
        grid-column-gap: 5px;
        grid-row-gap: 5px;
        margin: 20px 0 0
    }

    @media(min-width: 768px) {
        .transaction__info {
            grid-template-columns: 1fr 1fr
        }
    }

    @media(min-width: 811px) {
        .transaction__info {
            grid-template-columns: repeat(auto-fit, minmax(1px, 1fr))
        }
    }

    .transaction__data--title {
        font-size: 17px
    }

    .transaction__data--no-comb {
        color: #888;
        font-size: 17px;
        text-align: center;
        margin: 20px 0
    }

    .transaction__data--no-comb+* {
        margin-top: 30px
    }

    .transaction__data--date {
        color: #888;
        font-size: 14px
    }

    .transaction__data--id-date {
        color: #888;
        font-size: 14px;
        display: grid;
        grid-template-columns: -webkit-max-content -webkit-max-content;
        grid-template-columns: max-content max-content;
        justify-content: space-between;
        margin: 5px 0
    }

    .transaction__data--shield {
        background: #253548;
        padding: 10px;
        display: grid;
        border-radius: 5px;
        margin: 0;
        grid-template-columns: -webkit-max-content 1fr;
        grid-template-columns: max-content 1fr;
        justify-items: center;
        grid-column-gap: 10px;
        align-items: center
    }

    .transaction__data--title {
        color: #ddd;
        font-size: 18px;
        margin-top: 20px
    }

    @media(min-width: 811px) {
        .transaction__data--session {
            grid-template-columns: unset;
            grid-row-gap: 5px;
            row-gap: 5px
        }
    }

    .transaction__data--id {
        grid-template-columns: minmax(0, 1fr)
    }

    .transaction__data--id .transaction__value {
        word-wrap: break-word;
        max-width: 100%
    }

    @media(min-width: 811px) {
        .transaction__data--line-info {
            grid-column-end: span 5
        }
    }

    .transaction__label--shield {
        color: #888
    }

    .transaction__value--shield {
        color: #ddd
    }

    .transaction__field {
        grid-area: field;
        display: grid;
        grid-template-columns: .8fr 3fr;
        grid-column-gap: 5px
    }

    .transaction__line-info {
        display: grid;
        grid-row-gap: 5px;
        row-gap: 5px;
        grid-column-gap: 5px;
        -moz-column-gap: 5px;
        column-gap: 5px
    }

    @media(min-width: 768px) {
        .transaction__line-info {
            grid-template-columns: repeat(auto-fit, minmax(1px, 1fr))
        }
    }

    .transaction__entry {
        background-color: #16202b;
        color: #ddd;
        border-radius: 5px;
        margin: 10px 0;
        display: grid;
        grid-template: "field" "id" "win";
        padding: 5px;
        grid-gap: 5px
    }

    .transaction__entry--awp {
        grid-template: none
    }

    @media(min-width: 811px) {
        .transaction__entry--awp {
            grid-template-columns: minmax(125px, .3fr);
            grid-template-areas: "s";
            grid-auto-columns: 1fr;
            grid-auto-flow: column
        }
    }

    .transaction__roulette {
        display: grid;
        grid-column-gap: 5px;
        grid-column-gap: 15px;
        -moz-column-gap: 15px;
        column-gap: 15px;
        grid-row-gap: 15px;
        row-gap: 15px;
        background: #16202b;
        padding: 15px 5px;
        margin-top: 10px
    }

    @media(min-width: 811px) {
        .transaction__roulette {
            grid-template-columns: repeat(3, 1fr)
        }
    }

    .transaction__roulette-bet {
        background: #1c2939;
        padding: 5px;
        display: grid;
        grid-row-gap: 5px;
        row-gap: 5px
    }
</style>