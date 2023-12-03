// get notfication by ajax, 50 seconds interval, to update label of menu
$(document).ready(function(){
    updatMenuLabel();
    const update_label_interval = setInterval(function(){
        updatMenuLabel();
    }, 30000);
});

function updatMenuLabel(){
    $.ajax({
        url: '/get-label-menu',
        type: 'GET',
        dataType: 'json',
        success: function(response){
            console.log(response);
            if(response.status == 'success'){
                $('#left-menu-customers .badge').html(response.data.customers);
                $('#left-menu-customer-services .badge').html(response.data.customers_services);
                $('#left-menu-customer-services-remarketing .badge').html(response.data.customers_services_remarketing);
            }else{
                console.log('error in getting label menu');
            }
        }
    });

}

// usa o jquery mask para formatar em R$ todos os inputs com class mask-money
$(document).ready(function(){
    $('.mask-money').mask('000.000,00', {reverse: true});
});
