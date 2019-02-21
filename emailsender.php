<?php
// just edit these 
$to = $_POST["to"]; // correo del usuario
$pdftouse = $_POST["pdf"];
$from = "noreplay@centrocardiometabolico.net"; // correo de quien lo envia
$subject = "Resultados de prueba cardiovascular"; // asunto del correo 
#contenido del correo
$body = "<p>Reciba un cordial saludo.<br/>Anexo a este correo esta un documento con recomendaciones segun 
            calificacion en nuestra calculadora de riesgo cardiovascular.<br/><br/>"; // cuerpo del correo
$body.= "   Cualquier duda o consulta no dude en ponerse en contacto con nosotros. <br/> tel:2213-9400/7862-6108 </p>";
$body.= "Información enviada desde <a href='http://centrocardiometabolico.net'>centrocardiometabolico</a>";

$pdfLocation = "pdf/".$pdftouse; // file location
$pdfName = "Resultado Test.pdf"; // pdf file name recipient will get
$filetype = "application/pdf"; // type


/**************************************************************************************/

// crea los headers y mime boundary
$eol = PHP_EOL;
$semi_rand = md5(time());
$mime_boundary = "==Multipart_Boundary_$semi_rand";
/*
$headers = "From: $from $eol  X-Sender:$from $eol MIME-Version: 1.0$eol \r\n" .
    "Content-Type: multipart/mixed;$eol boundary=\"$mime_boundary\"";
*/

$headers =  "From: ". $from ."\r\n";
$headers .= "X-Sender: ". $from ."\r\n";
$headers .= "MIME-Version: 1.0 \r\n";
$headers .= "Content-Type: multipart/mixed;$eol  boundary=\"$mime_boundary\"";


// agrega el cuerpo HTML
$message = "--$mime_boundary$eol" .
    "Content-Type: text/html; charset=\"iso-8859-1\"$eol" .
    "Content-Transfer-Encoding: 7bit$eol$eol$body$eol";

// fetches pdf
$file = fopen($pdfLocation, 'rb');
$data = fread($file, filesize($pdfLocation));
fclose($file);
$pdf = chunk_split(base64_encode($data));

// attaches pdf to email
$message .= "--$mime_boundary$eol" .
    "Content-Type: $filetype;$eol name=\"$pdfName\"$eol" .
    "Content-Disposition: attachment;$eol filename=\"$pdfName\"$eol" .
    "Content-Transfer-Encoding: base64$eol$eol$pdf$eol--$mime_boundary--";

// envia el mensaje
mail($to, $subject, $message, $headers)?>