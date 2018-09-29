<?php
    // We'll be outputting a XLSX
    header('Content-type: application/xlsx');

    // It will be called
    header('Content-Disposition: attachment; filename="'.$filename.'"');

    // The XLSX source
    readfile($filename);
?>