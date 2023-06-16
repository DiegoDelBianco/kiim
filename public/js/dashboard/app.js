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