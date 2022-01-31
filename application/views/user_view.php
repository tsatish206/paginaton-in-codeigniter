<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <style type="text/css">
    a {
      padding-left: 5px;
      padding-right: 5px;
      margin-left: 5px;
      margin-right: 5px;
    }
    </style>
  </head> 
  <body>
 
   <!-- Posts List -->
   <table border='1' width='100%' style='border-collapse: collapse;' id='postsList'>
     <thead>
      <tr>
        <th>S.no</th>
        <th>Title</th>
        <th>Content</th>
      </tr>
     </thead>
     <tbody></tbody>
   </table>
 
   <!-- Paginate -->
   <div style='margin-top: 10px;' id='pagination'></div>

   <!-- Script -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script type='text/javascript'>
   $(document).ready(function(){
     // Detect pagination click
     $('#pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
       loadPagination(pageno);
     });

     loadPagination(0);

     // Load pagination
     function loadPagination(pagno){
       $.ajax({
         url: '<?=base_url()?>/User/loadRecord/'+pagno,
         type: 'get',
         dataType: 'json',
         success: function(response){
            $('#pagination').html(response.pagination);
            createTable(response.result,response.row);
         }
       });
     }

     // Create table list
     function createTable(result,sno){
       sno = Number(sno);
       $('#postsList tbody').empty();
       for(index in result){
          var id = result[index].id;
          var title = result[index].title;
          var content = result[index].content;
          content = content.substr(0, 60) + " ...";
          var link = result[index].link;
          sno+=1;

          var tr = "<tr>";
          tr += "<td>"+ sno +"</td>";
          tr += "<td><a href='"+ link +"' target='_blank' >"+ title +"</a></td>";
          tr += "<td>"+ content +"</td>";
          tr += "</tr>";
          $('#postsList tbody').append(tr);
 
        }
      }
    });
    </script>
  </body>
</html>