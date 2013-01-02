var searchDefault = 'szukaj w katalogu...';
var addDefault = 'wpisz adres swojej strony internetowej, np. http://www.moja-strona-internetowa.com';

$(function(){
    
    $('.selectCategory').selectbox();
    
//    $('.selectbox-wrapper ul li').click(function () {
//            $(this).parents('.selectbox-wrapper').hide();
//         });
    
    $(".categories-level-1").height($(".categories").height()-80);
  
    var stepOneAdresField = $('.add div.step-1 input[name="www"]');
    $('.search input').val(searchDefault);
    stepOneAdresField.val(addDefault);

    $('.goUp').click(function(){
        $.scrollTo( 0, 1000);
    });
	
    $('.search input[type=text]').focusin(function(){
        if($(this).val()==searchDefault){
            $(this).val('');
        }
    }).focusout(function(){
        if(!$(this).val()){
            $(this).val(searchDefault);
        }
    });
	
    stepOneAdresField.focusin(function(){
        if($(this).val()==addDefault){
            $(this).val('');
        }
    }).focusout(function(){
        if(!$(this).val()){
            $(this).val(addDefault);
        }
    }).keypress(function (key) {
        if (key.which == 13) {
            $('.add .step-1 a').trigger('click');
            return false;
        }
    });	
	
    $('.add .step-1 a').click(function(){
        var addUrl = $('.add input').val();
        var testQueryUrl = new RegExp('^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)');
		
        if(testQueryUrl.test(addUrl)) {
            $('.step-1').animate({
                height:'hide'
            },
            500,
            function(){
                $('form[name="catalogForm"] input[name="www"]').val(addUrl);
                $.ajax({
                    type: "POST",
                    url: 'web/ajaxgetmetatags/',
                    data: 'url=' + addUrl,
                    dataType: 'json',
                    success: function(response)
                    {
                        $('form[name="catalogForm"] input[name="title"]').val(response.title);
                        $('form[name="catalogForm"] textarea[name="description"]').val(response.description);
                        $('form[name="catalogForm"] input[name="keywords"]').val(response.keywords);
                        
                    }
                });
                $('.step-2').animate({
                    height:'show'
                },
                500);
            });
        } else {
            $('.bad-url-notification').show();
        }
    }); 
	
	
    $('form[name="catalogForm"]').live('submit',function(){
        $.ajax({
            type: "POST",
            url: 'web/ajaxadd/',
            data: $(this).serialize(), // serializes the form's elements.
            success: function(response)
            {
                $('.step-2').html(response);
                    $('.selectCategory').selectbox();
                
            }
        });
        return false;
    });
    
    // 'ul.sbOptions li a'
    // $(this).parent().parent().parent().find('a.sbSelector').text()

    $('form[name="catalogForm"] select[name="category_parent"], form[name="catalogForm"] select[name="category_parent2"]').live('change',function(){
        if($(this).attr('name') == 'category_parent2') {
            var subcategory = $('form[name="catalogForm"] select[name="id_category2"]');
        }else{
            var subcategory = $('form[name="catalogForm"] select[name="id_category"]');
        }
        
        var idCategory = $(this).val();
        $.ajax({
            type: "POST",
            url: 'category/ajaxgetchildrenselect/',
            data: 'category=' + $(this).val(), // serializes the form's elements.
            dataType: 'json',
            success: function(response)
            {
                subcategory.empty();
                $.each(response, function(key, value) {
                    subcategory.append($("<option/>", {
                        value: key,
                        text: value
                    }));
                });
            }
        });
        return false;
    });
    
    /* event debug */
    //	var clickEvents = $('.step-1 a').data("events").click;
    //	jQuery.each(clickEvents, function(key, handlerObj) {
    //	  console.log(handlerObj.handler) // prints "function() { console.log('clicked!') }"
    //	})

});
