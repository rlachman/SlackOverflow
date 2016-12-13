 <?php  
 $connect = mysqli_connect("localhost", "admin", "M0n@rch$", "slackoverflow");  
 $output = '';  
 $sql = "SELECT * FROM users WHERE user_name LIKE '%".$_POST["search"]."%'";  
 $result = mysqli_query($connect, $sql);  
 if(mysqli_num_rows($result) > 0)  
 {  
      $output .= '<h4 align="center">Users</h4>';  
      $output .= '<div class="table-responsive">  
                          <table class="table table bordered">  
                               <tr>  
                                    <th>Name</th>  
                                      
                                     
                               </tr>';  
      while($row = mysqli_fetch_array($result))  
      {  //           <a href="makeAdmin.php?user_id='.$row['user_id'].'"><span class="label label-primary">Admin</span></a>
           $output .= '  
                <tr>  
                     <td><a href="profile.php?ext_user='.$row['user_id'].'&ext_user_name='.$row['user_name'].'">'.$row['user_name'].'</a></td> 
                     
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