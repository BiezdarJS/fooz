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