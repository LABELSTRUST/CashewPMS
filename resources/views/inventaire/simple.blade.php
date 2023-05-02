<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Etiquette de produit avec Bootstrap</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
      .product-label p {
  font-size: 1rem;
  line-height: 1.2;
  margin: 0.5rem 0;
}

.barcode, .qr-code {
  margin-top: 1rem;
  width: 100%;
  height: 1rem;
  background-color: #eee;
}

    </style>
  </head>
  <body>
    <div class="container">
      <div class="product-label">
        <p>Date de fabrication : 15/04/2023</p>
        <p>Date d'expiration : 15/04/2024</p>
        <p>Quantité : 100</p>
        <p>Prix : $20</p>
        <p>Code du produit : 123456789</p>
        <p>Désignation : Nom du produit</p>
        <div class="barcode"></div>
        <div class="qr-code"></div>
      </div>
      
    </div>
  </body>
</html>
