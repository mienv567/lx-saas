function isSaleable()
{
	var itemId = $.trim($('#saleItemId').val());
	var price = $.trim($('#currentPrice').text());
    var saleable = ($.trim($('#saleable').val()) == '0') ? false : true;
    return (itemId && price && saleable);
}
function setBuyButtonStatus()
{
    if (isSaleable()) {
        $('#btnBuy').removeClass('btn-gray');
    } else {
        $('#btnBuy').addClass('btn-gray');
    }
}
function buyNow()
{
    if (isSaleable()) {
        var productId = $('#productId').val();
        var saleItemId = $('#saleItemId').val();
        document.location.href = "submit_order?id=" + productId + "&item_id=" + saleItemId;
    } else {
        //
    }
}
$(document).ready(function(){
    $(".chooseboxes .choosebox").bind("click",function(){
       $(this).siblings(".choosebox").removeClass("active");
       $(this).addClass("active");

       var itemId = $(this).attr("data-id");
       var price = $(this).attr("data-price");
       var salesprice = $(this).attr("data-salesprice");
       $('#saleItemId').val(itemId);
       $(this).parents(".detaillistbox").find(".price").text(price);
       $(this).parents(".detaillistbox").find(".salesprice").text(salesprice);
       setBuyButtonStatus();
    });
    setBuyButtonStatus();
});