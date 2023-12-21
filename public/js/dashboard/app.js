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

// mascara para telefone
$(document).ready(function(){
    $('.mask-phone').mask('(00) 0 0000-0000');
});


// add whatsapp button with number 11965966300, fixed in bottom right
$(document).ready(function(){
    $('body').append(`
    <style>
    #whatsapp-button-suport:after{
        content: 'Suporte';
        font-size: 0.3em;
        background-color: #128c7e;
        color: white;
        position: absolute;
        bottom: -22px;
        left: 0px;
        width: 100%;
        text-align: center;
        padding: 2px 5px;
        border-radius: 3px;
        z-index: 1001;
    }
    </style>
    <a style="
        position: fixed;
        bottom: 35px;
        right: 25px;
        z-index: 1000;
        font-size: 3em;
        width: 1.3em;
        height: 1.3em;
        background: radial-gradient(white, transparent);
        border-radius: 50%;
        text-align: center;
        color: #128c7e;"
        id='whatsapp-button-suport'
        href="https://api.whatsapp.com/send?phone=5511965966300" target="_blank"><i class="fab fa-whatsapp"></i></a>`);
});
