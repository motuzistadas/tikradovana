
$(function(){
	$('.menu-icon').click(function() {
		$(this).toggleClass("open");
	  	$('#menu_list').slideToggle()
	});

    $('.clr_menu').click(function() {
        $(this).toggleClass("open");
        $('.coloring_list').slideToggle()
    });

    $('.download_qr').click(function() {
        window.location.href = '/download';
    });

});

$(document).on('input', '#height', function() {
        $('.height').html( $(this).val() );
});

$(document).on('input', '#weight', function() {
        $('.weight').html( $(this).val() );
});

$(document).on('input', '#ring', function() {
        $('.ring').html( $(this).val() );
});

$(document).on('input', '#shoe', function() {
        $('.shoe').html( $(this).val() );
});

/*$( function() {
    $( ".sortable" ).sortable();
    $( ".sortable" ).disableSelection();
  } );*/

$(document).ready(function() {
    var max_fields      = 10; 
    var parent         = $(".own_interests"); 
    var add_button      = $(".add"); 
   
    var x = 1; 
    $(add_button).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ 
            x++; 
            $(parent).append('<div><input type="text" name="own_interest[]" required><a href="#" class="delete_field"><i class="fa fa-times" aria-hidden="true"></i></a></div>'); //add input box
        }
    });
   
    $(parent).on("click",".delete_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })


    /*******Dislikes******/

    var parent_dislike         = $(".own_dislikes"); 
    
   
    var x = 1; 
    $(add_button).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ 
            x++; 
            $(parent_dislike).append('<div><input type="text" name="own_dislike[]" required><a href="#" class="delete_field"><i class="fa fa-times" aria-hidden="true"></i></a></div>'); //add input box
        }
    });
   
    $(parent_dislike).on("click",".delete_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })


   /* $('.chbox').click(function(){
        var item = $(this).attr('name');
        $('.'+item).slideToggle();
    });*/




    /**********BACKGROUND IMAGE CHANGE**********/

    var i = 0;

    $(".next-theme").click(function() {
        i++;
        if (i > 10){ i = 1; };
        switch (i) {
            case 1:
            var color = 'rgb(118, 139, 137)';
            break;
            case 2:
            var color = 'rgb(8, 114, 128)';
            break;
            case 3:
            var color = 'rgb(230, 49, 100)';
            break;
            case 4:
            var color = 'rgb(0, 0, 0)';
            break;
            case 5:
            var color = 'rgb(138, 167, 201)';
            break;
            case 6:
            var color = 'rgb(0, 130, 66)';
            break;
            case 7:
            var color = 'rgb(152, 180, 164)';
            break;
            case 8:
            var color = 'rgb(92, 206, 133)';
            break;
            case 9:
            var color = 'rgb(13, 120, 133)';
            break;
            case 10:
            var color = 'rgb(146, 66, 173)';
            break;
        }
        $('header').css('background-image',  'url(headers/' + i + '.png)');
        $('.bg_color').css('background-color', color);
        $('#bg_iamge').val(i);
        $('#bg_color').val(color);
        $('.font_color').css('color', color);
        $('.clr').css('border-top', '2px dashed '+color);
    });

    $(".prev-theme").click(function() {
        i--;
        if (i <= 0) { i = 10; };
        switch (i) {
            case 1:
            var color = 'rgb(118, 139, 137)';
            break;
            case 2:
            var color = 'rgb(8, 114, 128)';
            break;
            case 3:
            var color = 'rgb(230, 49, 100)';
            break;
            case 4:
            var color = 'rgb(0, 0, 0)';
            break;
            case 5:
            var color = 'rgb(138, 167, 201)';
            break;
            case 6:
            var color = 'rgb(0, 130, 66)';
            break;
            case 7:
            var color = 'rgb(152, 180, 164)';
            break;
            case 8:
            var color = 'rgb(92, 206, 133)';
            break;
            case 9:
            var color = 'rgb(13, 120, 133)';
            break;
            case 10:
            var color = 'rgb(146, 66, 173)';
            break;
        }
        $('header').css('background-image',  'url(headers/' + i + '.png)');
        $('.bg_color').css('background-color', color);
        $('#bg_iamge').val(i);
        $('#bg_color').val(color);
        $('.font_color').css('color', color);
    });

    var b = 0;
    $(".next-background").click(function() {
         b++;
        if (b > 18){ b = 1; };
        $('body').css('background',  'url(backgrounds/b' + b + '.png) repeat scroll 0% 0%');
        $('#header_image').val(b);
    });

    $(".prev-background").click(function() {
        b--;
        if (b <= 0) { b = 18; };
        $('body').css('background',  'url(backgrounds/b' + b + '.png) repeat scroll 0% 0%');
        $('#header_image').val(b);
    });

});

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.last').css('display', 'block');
                $('#list-img')
                    .attr('src', e.target.result)
                    .width(85);
                $('#added-radio').prop('checked', true);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

/*******ADD EMAIL**********/

$(document).ready(function() {
    var max      = 10; 
    var prnt         = $(".emails"); 
    var add_btn      = $(".add_email"); 
   
    var x = 1; 
    $(add_btn).click(function(e){ 
        e.preventDefault();
        if(x < max){ 
            x++; 
            $(prnt).append('<div><input required name="email[]" type="text" /><a href="#" class="delete_field"><i class="fa fa-times" aria-hidden="true"></i></a></div>'); //add input box
        }
    });
   
    $(prnt).on("click",".delete_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});


 $(document).ready(function() {
        $("form").submit(function() {
            if($("input[type='text']").val()=="") {
                    $("input[type='text']").prop('disabled', true);
            }
        });
});

/**********JAVASCRIPT*************/

function font(jscolor) {
    document.getElementById('container').style.color = '#' + jscolor
}

