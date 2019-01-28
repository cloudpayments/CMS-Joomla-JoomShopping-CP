<?php 
    function my_copy_all($from, $to, $rewrite = true) {
        if (is_dir($from)) {
          @mkdir($to);
          $d = dir($from);
          while (false !== ($entry = $d->read())) {
            if ($entry == "." || $entry == "..") continue;
              if (my_copy_all("$from/$entry", "$to/$entry", $rewrite)):
              else:
            //  echo 'error copy file 2';
            //  die();
              endif;
            }
            $d->close();
        }
          else {
            if (!file_exists($to) || $rewrite)
            if(copy($from, $to)):
            else:
              echo __DIR__.' error copy file form '.$from.' to '.$to;
              die();
            endif;
          }
    }


$old_dir = $_SERVER['DOCUMENT_ROOT'].'/joomla/plugins/jshoppingadmin/cloudpayments_cp/install/pm_cloudpayments_cp/';
$new_dir =$_SERVER['DOCUMENT_ROOT'].'/joomla/components/com_jshopping/payments/pm_cloudpayments_cp/';
my_copy_all($old_dir,$new_dir, false); 
  
  
?> 