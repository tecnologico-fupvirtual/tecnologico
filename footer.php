<?php
  $footerYear = isset($anio) ? $anio : (isset($año) ? $año : date('Y'));
?>
<footer class="footer text-center"> <?php echo htmlspecialchars($footerYear, ENT_QUOTES, 'UTF-8'); ?> &copy; FUPVIRTUAL </footer>
