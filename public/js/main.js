var mainRefresh, currencyRefresh;
var buy_flag=0;
var retrytimes=0, cancel_retrytimes=0;
var bid_value=0.0, ask_value=0.0;
var mybtcamount=0.0,mycnyamount=0.0,total=0.0,myfrozenbtcamount=0.0,myfrozencnyamount=0.0;
var breakpoint=0,marketstatus=1,marketstatus_old=-1;
var allowance_up=30.0, allowance_down=15.0, handler_menge=0.0, frequency=3000,thresholdvalue=500;
var auto_status=0, buy_status=0, lock_status=0;
var marketvalue=new Array();
var breakpoints = new Array();
var buyprice = new Array();
var buyprice_old = new Array();
var graphic = new Array();
var frozen_timeout, cancel_timeout, order_timeout;
var refresh_currency_flag=1, refresh_currency_value=30000;
var lock_times=0;

function sendAjax(mURL, mData, callback) {
    $.ajax({
        url: mURL,
        type: 'post',
        data: mData,
        cache: false,
        success: callback,
        error: function (xhr, ajaxOptions, thrownError) {
            // alert(xhr.status);
            // alert(xhr.responseText);
            // alert(thrownError);
        }
    });
}
function initProgramm() {
    getAccountInfo();
    getMarketDepth2();
    getDeposits();
    getTransactions();
}

function getDeposits() {
    sendAjax('/getDeposits','',function(result){
        $('#deposits_info').html(result);
    });        
}

function getTransactions() {
    sendAjax('/getTransactions','',function(result){
        $('#transactions_info').html(result);
    });        
}

function getOrders() {
    sendAjax('/getOrders','',function(result){
        $('#orders_info').html(result);
    });
}

function getAccountInfo() {
    sendAjax('/getAccountInfo','', function(result){
        $('#account_info').html(result);
        getCurrency();
        BuyCheck();
    });  
}

function refreshCurrency() {
    sendAjax('/getAccountInfo','', function(result){
        $('#account_info').html(result);
        getCurrency();
    });    
}

function getMarketDepth2() {
    sendAjax('/getMarketDepth2','', function(result){
        $('#market_info').html(result);
        controlcenter();
    });
}

function buyOrder_manual(price, amount) {
    var mData = {
        price: price,
        amount: amount,
    }
    sendAjax('/buyOrder', mData, function(result) {
        if(price=="0"||price=="") {
            price = "市价";
        }
        if(result=="Success") {
            writeOrderLog("手动下买单 <--- 买入数量: "+amount+" 买入价格: "+price+" 时间: "+getCurrentTime(true));
        } else {
            writeOrderLog("手动下买单失败! 买入数量: "+amount+" 买入价格: "+price+" 错误代码: " +result+" 时间: "+getCurrentTime(true)); 
        }
        $('#manual_buy_button').prop("disabled",false);
        $('#manual_buy_price_input').val("");
        $('#manual_buy_amount_input').val("");
    });
}

function sellOrder_manual(price, amount) {
    var mData = {
        price: price,
        amount: amount,
    }
    sendAjax('/sellOrder', mData, function(result) {
        if(price=="0"||price=="") {
            price = "市价";
        }
        if(result=="Success") {
            writeOrderLog("手动下卖单 <--- 卖出数量: "+amount+" 卖出价格: "+price+" 时间: "+getCurrentTime(true));
        } else {
            writeOrderLog("手动下卖单失败! 卖出数量: "+amount+" 卖出价格: "+price+" 错误代码: " +result+" 时间: "+getCurrentTime(true)); 
        }
        $('#manual_sell_button').prop("disabled",false);
        $('#manual_sell_price_input').val("");
        $('#manual_sell_amount_input').val("");
    });
}

function buyOrder(price, amount) {
    lock_status=1;
    $('#lock_status_value').text('下单锁定: 锁定');
    var mData = {
        price: price,
        amount: amount,
    }
    sendAjax('/buyOrder',mData, function(result){
        if(result=="Success") {
            retrytimes=0;
            writeOrderLog("下买单 <--- 买入数量: "+amount+" 买入价格: "+price+" 当前人民币余额: "+mycnyamount+" 当前比特币余额: "+mybtcamount+"被冻结人民币"+myfrozencnyamount+"被冻结比特币"+myfrozenbtcamount+" 时间: "+getCurrentTime(true));
            getOrderStatus(1, price);
            refreshCurrency();
        } else {
            lock_status=0;
            $('#lock_status_value').text('下单锁定: 未锁定');
            writeOrderLog("下买单失败! 买入数量: "+amount+" 买入价格: "+price+" 错误代码: " +result+" 当前人民币余额: "+mycnyamount+" 当前比特币余额: "+mybtcamount+"被冻结人民币"+myfrozencnyamount+"被冻结比特币"+myfrozenbtcamount+" 时间: "+getCurrentTime(true));
            refreshCurrency();
        }
    });
}

function sellOrder(price, amount) {
    lock_status=1;
    $('#lock_status_value').text('下单锁定: 锁定');
    var mData = {
        price: 0,
        amount: amount,
    }
    sendAjax('/sellOrder',mData, function(result){
        if(result=="Success") {
            retrytimes=0;
            writeOrderLog("下卖单 ---> 卖出数量: "+amount+" 卖出价格: "+price+" 当前人民币余额: "+mycnyamount+" 当前比特币余额: "+mybtcamount+"被冻结人民币"+myfrozencnyamount+"被冻结比特币"+myfrozenbtcamount+" 时间: "+getCurrentTime(true));
            getOrderStatus(0, price);
            refreshCurrency();
        } else {
            lock_status=0;
            $('#lock_status_value').text('下单锁定: 未锁定');
            writeOrderLog("下卖单失败! 卖出数量: "+amount+" 卖出价格: "+price+" 错误代码: "+result+" 当前人民币余额: "+mycnyamount+" 当前比特币余额: "+mybtcamount+"被冻结人民币"+myfrozencnyamount+"被冻结比特币"+myfrozenbtcamount+" 时间: "+getCurrentTime(true));
            refreshCurrency();
        }
    });
}

function cancelOrder_manual() {
    sendAjax('/getOrderStatus','', function(result){
        if (result=="closed") {
            writeOrderLog("没有可以取消的定单！ 时间: "+getCurrentTime(true));
            lock_times=0;
        } else {
            var mData = {
                id: result
            }
            sendAjax('/cancelOrder',mData, function(_result){
                if(_result=="Success") {
                    writeOrderLog("成功取消定单! 时间: "+getCurrentTime(true));
                    lock_times=0;                
                } else {
                    writeOrderLog("取消定单失败! 错误代码: "+_result+" 时间: "+getCurrentTime(true));
                }
            });
        }
    });
}

function cancelOrder(id,status) {
    clearTimeout(cancel_timeout);
    var mData = {
        id: id
    }
    sendAjax('/cancelOrder',mData, function(result){
        if(result=="Success") {
            cancel_retrytimes=0;
            lock_times=0; 
            if(status){
                buy_flag=1;
                writeOrderLog("成功取消买定单！ 时间: "+getCurrentTime(true));  
            } else {
                writeOrderLog("成功取消卖定单！ 时间: "+getCurrentTime(true));                  
            }
            waitforFrozen();
        } else {
            cancel_retrytimes++;
            if(status){
                writeOrderLog("取消买定单失败! 重试次数: "+retrytimes+" 错误代码: "+result+" 时间: "+getCurrentTime(true));                
            } else {
                writeOrderLog("取消卖定单失败! 重试次数: "+retrytimes+" 错误代码: "+result+" 时间: "+getCurrentTime(true));
            }
            cancel_timeout = setTimeout(function(){cancelOrder(id,status)}, 5000);
        }
    });
}

function getOrderStatus(status, price) {
    clearTimeout(order_timeout);
    sendAjax('/getOrderStatus','', function(result){
        if (result=="closed") {
            buy_flag=0;
            refreshStatus(status, price);
        } else {
            retrytimes++;
            if(retrytimes>5) {
                writeOrderLog("下单等待时间过长 进入退单程序... 时间: "+getCurrentTime(true));
                cancelOrder(result,status);
            } else {
                if(status) {
                    writeOrderLog("买单等待中... 重试次数: "+retrytimes+" 时间: "+getCurrentTime(true));
                } else {
                    writeOrderLog("卖单等待中... 重试次数: "+retrytimes+" 时间: "+getCurrentTime(true));
                }
                order_timeout = setTimeout(function(){getOrderStatus(status, price)}, 1000);
            }
        }
    });  
}

function refreshStatus(status, price) {
    sendAjax('/getAccountInfo','', function(result){
        $('#account_info').html(result);
        getCurrency();
        if(status) {
            writeOrderLog("已成功买入! 价格: "+price+" 当前余额 人民币: " + mycnyamount.toFixed(2)+ " 比特币: " + mybtcamount.toFixed(8) + " 判断点: "+breakpoint.toFixed(2)+" 时间: "+getCurrentTime(true));
            buy_status=1;
            buyprice.push([getCurrentTime(false), parseFloat(price)]);
        } else {
            writeOrderLog("已成功卖出! 价格: "+price+" 当前余额 人民币: " + mycnyamount.toFixed(2)+ " 比特币: " + mybtcamount.toFixed(8) + " 判断点: "+breakpoint.toFixed(2)+" 时间: "+getCurrentTime(true));  
            buy_status=0;
            buyprice.push([getCurrentTime(false), parseFloat(price)]);
            buyprice_old.push(buyprice);
            buyprice=[];
        }
        $("#order_logs").animate({ scrollTop: $("#order_logs")[0].scrollHeight }, 300);
        if(buy_status){
            $('#buy_status_value').text('买卖状态: 卖');
        } else {
            $('#buy_status_value').text('买卖状态: 买');
        }
    });
    getDeposits();
    getTransactions();
}

function refreshPrice() {
    bid_value=parseFloat($('#em_bid_value').text());
    ask_value=parseFloat($('#em_ask_value').text());
    $('#bid_value').text('委买: '+bid_value);
    $('#ask_value').text('委卖: '+ask_value);         
}

function getCurrency() {
    mybtcamount=parseFloat($('#my_btc_amount').text());
    mycnyamount=parseFloat($('#my_cny_amount').text());
    myfrozenbtcamount=parseFloat($('#my_frozen_btc_amount').text());
    myfrozencnyamount=parseFloat($('#my_frozen_cny_amount').text());
    if (myfrozencnyamount==0&&myfrozenbtcamount==0) {
        lock_status=0;
        lock_times=0; 
        $('#lock_status_value').text('下单锁定: 未锁定');
    } else {
        lock_times++; 
        lock_status=1;
        $('#lock_status_value').text('下单锁定: 锁定');
        if (lock_times>10) {
            writeOrderLog("被锁定状态已重试10次 自动进入退单程序... 时间: "+getCurrentTime(true));
            cancelOrder_manual();
        }
    }
    //writeOrderLog("刷新资金... 人民币余额: "+mycnyamount+" 比特币余额: "+mybtcamount+" 被冻结人民币: "+myfrozencnyamount+" 被冻结比特币: "+myfrozenbtcamount+" 时间: "+getCurrentTime(true));
}

function refreshInfo() {
    $('#market_value').text('现价: '+bid_value);
    $('#breakpoint_value').text('判断点: '+breakpoint);
    var status;
    if(marketstatus==1) {
        status='涨';
        $('#market_status').text('市场: '+status);
        $('#market_value_all ul').append("<li style='background-color: #A9F5A9' class='list-group-item'><span class='badge'>"+status+"</span>"+bid_value+"</li>");
    } else if (marketstatus==-1){
        status='跌';
        $('#market_status').text('市场: '+status);
        $('#market_value_all ul').append("<li style='background-color: #F5A9A9' class='list-group-item'><span class='badge'>"+status+"</span>"+bid_value+"</li>");
    } else if (marketstatus==0){
        status='平';
        $('#market_status').text('市场: '+status);
        $('#market_value_all ul').append("<li class='list-group-item'><span class='badge'>"+status+"</span>"+bid_value+"</li>");        
    }
    $("#market_value_all").animate({ scrollTop: $("#market_value_all")[0].scrollHeight }, 300);
    $('#btc_rest').text('比特币余额: '+mybtcamount.toFixed(8));
    $('#cny_rest').text('人民币余额: '+mycnyamount.toFixed(2));
    $('#btc_frozen').text('被冻结比特币: '+myfrozenbtcamount.toFixed(8));
    $('#cny_frozen').text('被冻结人民币: '+myfrozencnyamount.toFixed(2));
    $('#total_rest').text('总资产: '+total.toFixed(2));
    $('#allowance_up_value').text('涨容差: '+allowance_up);
    $('#allowance_down_value').text('跌容差: '+allowance_down);
    $('#handler_menge_value').text('操作金额: '+handler_menge);
    $('#frequency_value').text('采样频率: '+frequency+' ms');
    $('#thresholdvalue_value').text('上下阀值: '+thresholdvalue);
    if(buy_status){
        $('#buy_status_value').text('买卖状态: 卖');
    } else {
        $('#buy_status_value').text('买卖状态: 买');
    }
    if(lock_status) {
        $('#lock_status_value').text('下单锁定: 锁定');
    } else {
        $('#lock_status_value').text('下单锁定: 未锁定');
    }
    if(auto_status) {
        $('#auto_status_value').text('自动: 开启');
    } else {
        $('#auto_status_value').text('自动: 关闭');
    }
    if(refresh_currency_flag) {
        $('#refrech_currency_status_value').text('更新资金: '+refresh_currency_value+'ms');
    } else {
        $('#refrech_currency_status_value').text('更新资金: 关闭');
    }
    $.plot("#placeholder", graphic, {
        lines: {
            show: true
        },
        grid: {
            hoverable: true,
            clickable: true
        },
        xaxis: {
            mode: "time",
        },
        legend: { position: "sw" }
    });
}

function BuyCheck() {
    var charge_value=0;
    if (handler_menge!=0) {
        charge_value=handler_menge;
    } else {
        charge_value=mycnyamount;
    }
    if (mybtcamount<(charge_value/bid_value)-0.1) {
        buy_status=0;
        $('#buy_status_value').text('买卖状态: 买');
        writeOrderLog("自动切换买卖状态到买 时间: "+getCurrentTime(true));
    } else {
        buy_status=1;
        $('#buy_status_value').text('买卖状态: 卖');
        writeOrderLog("自动切换买卖状态到卖 时间: "+getCurrentTime(true));
    }        
}

function resetLog(){
    marketvalue=[];
    breakpoints=[];
    buyprice=[];
    buyprice_old=[];
    $('#market_value_all ul').html("");
    $.plot("#placeholder", []);
}

function writeOrderLog(log) {
    $('#order_logs ul').append("<li class='list-group-item'>"+log+"</li>");
    $("#order_logs").animate({ scrollTop: $("#order_logs")[0].scrollHeight }, 300);           
}

function waitforFrozen() {
    clearTimeout(frozen_timeout);
    if (lock_status) {
        refreshCurrency();
        writeOrderLog("等待释放被冻结资金... 被冻结人民币: "+myfrozencnyamount+" 被冻结比特币: "+myfrozenbtcamount+" 时间: "+getCurrentTime(true));
        frozen_timeout = setTimeout(function(){waitforFrozen()},2000);
    } else {
        writeOrderLog("被冻结资金已解冻... 被冻结人民币: "+myfrozencnyamount+" 被冻结比特币: "+myfrozenbtcamount+" 时间: "+getCurrentTime(true));
    }
}

function getCurrentTime(flag) {
    var date = new Date();
    if(flag) {
        return date.toLocaleTimeString();
    } else {
        return date.getTime();
    }
}

function buy(lastvalue){
    if(handler_menge!=0&&(handler_menge<mycnyamount)){
        var buy_menge = (handler_menge/lastvalue).toFixed(4);
    } else {
        var buy_menge = (mycnyamount/lastvalue).toFixed(4)-0.005;          
    }
    var buy_price=0;
    buy_price = lastvalue;
    if(buy_menge>0.01){
        buyOrder(buy_price, buy_menge);
    } else {
        writeOrderLog("卖数量过小 数量: "+sell_menge+" 将进行买卖状态自动检查 时间: "+getCurrentTime(true));
        BuyCheck();
    }  
}

function sell(lastvalue) {
    if(handler_menge!=0&&(handler_menge/lastvalue<mybtcamount)){
        var sell_menge = (handler_menge/(lastvalue)).toFixed(4);
    } else {
        var sell_menge = mybtcamount.toFixed(4)-0.005;                 
    }
    var sell_price = lastvalue;
    if(sell_menge>0.01){
        sellOrder(sell_price,sell_menge);    
    } else {
        writeOrderLog("买数量过小 数量: "+sell_menge+" 将进行买卖状态自动检查 时间: "+getCurrentTime(true));
        BuyCheck();
    }     
}

function controlcenter() {
    var unixTimestamp = getCurrentTime(false);
    refreshPrice();
    total=mybtcamount*bid_value+mycnyamount;
    marketvalue.push([unixTimestamp,bid_value]);
    var lastvalue = marketvalue[marketvalue.length-1][1];
    var secondlastvalue = marketvalue[marketvalue.length-2][1];
    if (lastvalue>secondlastvalue) {
        marketstatus=1;
    } else if (lastvalue<secondlastvalue){
        marketstatus=-1;
    } else if (lastvalue==secondlastvalue){
        marketstatus=0;
    }
    if (breakpoint-lastvalue>0.5*allowance_up) {
        buy_flag=0;
    }
    if(auto_status&&!lock_status) {
        if (buy_status) {
            // sell
            if ((breakpoint-lastvalue>allowance_down)&&(breakpoint-lastvalue<thresholdvalue)) {
                sell(lastvalue);
            }
        } else {
            // buy
            if ((lastvalue-breakpoint>allowance_up)&&(lastvalue-breakpoint<thresholdvalue) || (buy_flag&&(lastvalue>breakpoint))) {
                buy(lastvalue);
            } 
        }        
    }
    if ((breakpoint-lastvalue)>allowance_down||(lastvalue-breakpoint)>allowance_up) {
        breakpoint=lastvalue;
    } else {
        if (buy_status) {
            if (lastvalue>breakpoint) {
                breakpoint=lastvalue;
            }
        } else {
            if (lastvalue<breakpoint) {
                breakpoint=lastvalue;
            }                
        }        
    }
    if(buy_status&&auto_status&&!lock_status) {
        buyprice.push([unixTimestamp, lastvalue]);
    }
    marketstatus_old=marketstatus;
    breakpoints.push([unixTimestamp,breakpoint]);
    graphic=new Array();
    graphic.push({ data: marketvalue, label: "市场价(元)" });
    graphic.push({ data: breakpoints, label: "判断点(元)" });
    graphic.push({ data: buyprice, label: "购入段当前(元)" });
    buyprice_old.forEach(function(_buyprice,index){
        graphic.push({ data: _buyprice, label: "购入段"+(index+1)+"(元)" });
    });
    if(marketvalue.length>1000) {
        resetLog();
    }
    refreshInfo();
}