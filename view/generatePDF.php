<?php
// Inclure le fichier du contrôleur
include '../../Controller/PublicationC.php';

// Vérifier si l'ID est fourni
if (!isset($_GET['id'])) {
    die('ID de publication non fourni');
}

$id = (int)$_GET['id'];

// Récupérer la publication
$publicationC = new PublicationC();
$publication = $publicationC->showPublication($id);

if (!$publication) {
    die('Publication non trouvée');
}

// Définir les en-têtes pour le PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="publication_' . $id . '.pdf"');

// Créer le contenu du PDF
$content = "
%PDF-1.7

1 0 obj
<< /Type /Catalog
   /Pages 2 0 R
>>
endobj

2 0 obj
<< /Type /Pages
   /Kids [3 0 R]
   /Count 1
>>
endobj

3 0 obj
<< /Type /Page
   /Parent 2 0 R
   /Resources << /Font << /F1 4 0 R >> >>
   /MediaBox [0 0 612 792]
   /Contents 5 0 R
>>
endobj

4 0 obj
<< /Type /Font
   /Subtype /Type1
   /BaseFont /Helvetica
>>
endobj

5 0 obj
<< /Length 1000 >>
stream
BT
/F1 16 Tf
50 700 Td
(" . str_replace(array("\n", "\r"), ' ', $publication['Titre']) . ") Tj

/F1 12 Tf
0 -30 Td
(" . str_replace(array("\n", "\r"), ' ', $publication['Contenu']) . ") Tj

/F1 10 Tf
0 -30 Td
(Date de publication: " . $publication['Date'] . ") Tj
ET
endstream
endobj

xref
0 6
0000000000 65535 f
0000000010 00000 n
0000000060 00000 n
0000000120 00000 n
0000000250 00000 n
0000000330 00000 n

trailer
<< /Size 6
   /Root 1 0 R
>>
startxref
1400
%%EOF
";

// Envoyer le PDF
echo $content;
?> 