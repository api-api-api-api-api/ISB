<?php
     $fpdf->AddPage();
    $fpdf->SetFont('Arial','B',16);
    $fpdf->Cell(40,10,'<table width="200" border="1">
  <tr>
    <td>sd</td>
    <td>asd</td>
    <td>ddd</td>
  </tr>
</table>');
    $fpdf->Output();
?>