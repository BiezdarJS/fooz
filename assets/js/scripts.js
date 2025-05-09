jQuery(document).ready(function($) {
  $('button.get-json-data').on('click', function(e) {
      e.preventDefault();
      
      const data = {
          action: '20_books_in_json', 
          nonce: getJsonData.nonce
      };

      $.ajax({
        url: getJsonData.ajax_url,
        data: data,
        type: 'POST', 
        success: (result) => {
          console.log(result);
        },
        error: (error) => {
          console.log(error);
        }
      });
  });
});





// Jak można za pomocą WordPress REST API zaktualizować pole custom field w niestandardowym typie posta?

(function($) {
  $('button.post-new-data').on('click', function(e) {
    e.preventDefault();

    $.ajax({
      url: 'http://localhost/uzi-menu/wp-json/wp/v2/library/172',
      type: 'POST',
      contentType: 'application/json',
      headers: {
        'X-WP-Nonce': getJsonData.rest_nonce
      },
      data: JSON.stringify({
        acf: {
          price: 543
        }
      }),
      success: function(response) {
        console.log('Sukces!', response);
      },
      error: function(error) {
        console.error('Błąd!', error);
      }

    });
});
  

})(jQuery);
