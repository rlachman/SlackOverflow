 <html>  
      <head>  
           <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
           <title>Webslesson Tutorial</title>  
           <script src="jquery.js"></script>  
           <script src="js/bootstrap.js"></script>  
           <link href="css/bootstrap.css" rel="stylesheet" />  
      </head>  
      <body>  
           <div class="container">  
                <br />  
                <h2 align="center">Ajax Live Data Search using Jquery PHP MySql</h2><br />  
                <div class="form-group">  
                     <div class="input-group">  
                          <span class="input-group-addon">Search</span>  
                          <input type="text" name="search_text" id="search_text" placeholder="Search by Customer Name" class="form-control" />  
                     </div>  
                </div>  
                <br />  
                <div id="result"></div>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#search_text').keyup(function(){  
           var txt = $(this).val();  
           if(txt != '')  
           {  
                $.ajax({  
                     url:"fetch.php",  
                     method:"post",  
                     data:{search:txt},  
                     dataType:"text",  
                     success:function(data)  
                     {  
                          $('#result').html(data);  
                     }  
                });  
           }  
           else  
           {  
                $('#result').html('');                 
           }  
      });  
 });  
 </script> 