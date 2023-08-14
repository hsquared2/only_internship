<?php
   require_once(__DIR__."/vendor/autoload.php");
   require_once(__DIR__."/classes/DiskManager.php");

   $diskManager = new DiskManager($token);

   $collection = $diskManager->getFiles();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   <link href="css/style.css" rel="stylesheet">
   <title>Document</title>
</head>
<body>
   <div class="container">
      <div class="upload_section">
         <h2 class="upload_section-header">Upload File</h2>
         <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <button type="submit" class="btn btn-primary">
               <i class="fa fa-upload" aria-hidden="true"></i> Upload file
            </button>
         </form>
      </div>
      <div class="files_section">
         <h2 class="files_section-header">All Files</h2>
         <table class="table">
            <thead>
               <tr class="table-primary">
                  <th scope="col">Name</th>
                  <th scope="col">Size</th>
                  <th scope="col">Delete</th>
                  <th scope="col">Download</th>
               </tr>
            </thead>
            <tbody>
               <? foreach ($collection as $item): ?>
                  <tr>
                     <td><?= $item['name'] ?></td>
                     <td><?= intdiv($item['size'], 1024) . " KB" ?></td>
                     <td>
                        <form action="delete.php" method="post">
                           <button type="submit" class="btn btn-danger" name="file_path" value=<?= $item['path'] ?>>
                              <i class="fa fa-times" aria-hidden="true"></i>
                           </button>
                        </form>
                     </td>
                     <td>
                        <form action="download.php" method="post">
                           <button type="submit" class="btn btn-primary" name="file_path" value=<?= $item['path'] ?>>
                              <i class="fa fa-download" aria-hidden="true"></i>
                           </button>
                        </form>
                     </td>
                  </tr>
               <? endforeach; ?>
            </tbody>
         </table>
      </div>
   </div>
</body>
</html>