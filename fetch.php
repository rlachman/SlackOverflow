 <?php  
 $connect = mysqli_connect("localhost", "root", "", "testing");  
 $output = '';  
 $sql = "SELECT * FROM tbl_customer WHERE CustomerName LIKE '%".$_POST["search"]."%'";  
 $result = mysqli_query($connect, $sql);  
 if(mysqli_num_rows($result) > 0)  
 {  
      $output .= '<h4 align="center">Search Result</h4>';  
      $output .= '<div class="table-responsive">  
                          <table class="table table bordered">  
                               <tr>  
                                    <th>Customer Name</th>  
                                    <th>Address</th>  
                                    <th>City</th>  
                                    <th>Postal Code</th>  
                                    <th>Country</th>  
                               </tr>';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
                     <td>'.$row["CustomerName"].'</td>  
                     <td>'.$row["Address"].'</td>  
                     <td>'.$row["City"].'</td>  
                     <td>'.$row["PostalCode"].'</td>  
                     <td>'.$row["Country"].'</td>  
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