 <?php  
 $connect = mysqli_connect("localhost", "admin", "M0n@rch$", "slackoverflow");  
 $output = '';  
 $sql = "SELECT * FROM users WHERE user_name LIKE '%".$_POST["search"]."%'";  
 $result = mysqli_query($connect, $sql);  
 if(mysqli_num_rows($result) > 0)  
 {  
      $output .= '<h4 align="center">Search Result</h4>';  
      $output .= '<div class="table-responsive">  
                          <table class="table table bordered">  
                               <tr>  
                                    <th>Name</th>  
                                    <th>E-mail</th>  
                                     
                               </tr>';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
                     <td>'.$row["user_name"].'</td>  
                     <td>'.$row["user_email"].'</td>  
                </tr>  
           ';  
      }  
      echo $output;  
 }  
 else  
 {  
      echo 'Data Not Found';  
 }  
 ?>  