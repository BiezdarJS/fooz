jQuery(document).ready(function($) {
  $('button.get-json-data').on('click', function(e) {
      e.preventDefault();
      
      var data = {
          action: '20_books_in_json', 
          nonce: getJsonData.nonce
      };

      $.ajax({
        url: getJsonData.ajax_url,
        data: data,
        type: 'POST', 
        success: (data) => {
          console.log(data);
        },
        error: (error) => {
          console.log(error);
        }
      });
  });
});