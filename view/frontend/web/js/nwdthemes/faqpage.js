(function(jQuery) {

	jQuery(function($){

        //live search
        var highlight_settings = { className: 'faq-highlight', element: 'span' };
		alert("ASa");

            //default mode
            $("#faq-search").keyup(function(){
				alert("ff");
                //remove highlights
                $('.faqpage-container').unhighlight(highlight_settings);

                var filter = $(this).val(),
                    count = 0,
                    found_title = false,
                    found_body = false;
                $(".faqpage_question_block").each(function(){
                    //check question title
                    found_title = $('h3.faqpage_question', this).text().search(new RegExp(filter, "i"));
                    //check question body
                    found_body = $('.faqpage_answer', this).text().search(new RegExp(filter, "i"));

                    if (found_title < 0 && found_body < 0 ) {
                        $(this).fadeOut();
                    } else {
                        $(this).show();
                        count++;
                    }
                });

                // Update the count
                $("#faq-search-count").text(count);

                //highlight results
                $('.faqpage-container').highlight(filter, highlight_settings);

            });

            $('#faq-reset').click(function(){
                $("#faq-search").val('');
                $(".faqpage_question_block").show();
                $('.faqpage-container').unhighlight(highlight_settings);
                $("#faq-search-count").text('');
                return false;
            });

            $('.faqpage_list_categories a').click(function(){
                $('#faq-reset').trigger('click');
                return true;
            });
        

// ask a question

		$('.faq_ask_button').on('click', function() {
			$('.ask_question').slideDown(150);
			$('html, body').animate({scrollTop: $('.ask_question').offset().top}, 150);
			$('.faq_ask_button').hide();
			var dataForm = new VarienForm('faq_ask_form', true);
		});
		$('.cancel_faq_ask').on('click', function() {
			$('.faq_ask_button').show();
			$('.ask_question').slideUp(150);
		});

	});

});