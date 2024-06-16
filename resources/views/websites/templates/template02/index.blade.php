<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imóvel à Venda</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .header {
            background: url('header-bg.jpg') no-repeat center center;
            background-size: cover;
            color: white;
            text-align: center;
            padding: 4rem 1rem;
        }
        .header h1 {
            font-size: 3rem;
            margin: 0;
            color: #4CAF50
        }
        .content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .property-info, .contact-form, .seller-info, .location {
            margin-bottom: 2rem;
        }
        .property-info h2, .contact-form h2, .seller-info h2, .location h2 {
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 0.5rem;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        .gallery img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .contact-form button {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .contact-form button:hover {
            background-color: #45a049;
        }
        .map {
            width: 100%;
            height: 400px;
            border-radius: 8px;
        }
        footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 1rem;
            position: relative;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Imóvel à Venda</h1>
    </div>

    <div class="content">
        <div class="property-info">
            <h2>Detalhes do Imóvel</h2>
            <p><strong>Endereço:</strong> Avenida Exemplo, 456, Bairro Modelo, Cidade XYZ</p>
            <p><strong>Preço:</strong> R$ 750.000,00</p>
            <p><strong>Descrição:</strong> Imóvel moderno com 4 quartos, 3 banheiros, ampla sala de estar, cozinha gourmet, jardim e piscina. Localizado em área nobre, próximo a parques e shoppings.</p>
        </div>

        <div class="gallery">
            <img src="https://img.freepik.com/fotos-gratis/villa-com-piscina-de-luxo-espetacular-design-contemporaneo-arte-digital-imoveis-casa-casa-e-propriedade-ge_1258-150749.jpg" alt="Imagem 1 do imóvel">
            <img src="https://img.freepik.com/fotos-gratis/villa-com-piscina-de-luxo-espetacular-design-contemporaneo-arte-digital-imoveis-casa-casa-e-propriedade-ge_1258-150749.jpg" alt="Imagem 2 do imóvel">
            <img src="https://img.freepik.com/fotos-gratis/villa-com-piscina-de-luxo-espetacular-design-contemporaneo-arte-digital-imoveis-casa-casa-e-propriedade-ge_1258-150749.jpg" alt="Imagem 3 do imóvel">
            <img src="https://img.freepik.com/fotos-gratis/villa-com-piscina-de-luxo-espetacular-design-contemporaneo-arte-digital-imoveis-casa-casa-e-propriedade-ge_1258-150749.jpg" alt="Imagem 4 do imóvel">
        </div>

        <div class="contact-form">
            <h2>Entre em Contato</h2>
            <form action="enviar_contato.php" method="post">
                <input type="text" name="name" placeholder="Nome" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="message" rows="4" placeholder="Mensagem" required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>

        <div class="seller-info">
            <h2>Informações do Vendedor</h2>
            <p><strong>Nome:</strong> Maria Oliveira</p>
            <p><strong>Telefone:</strong> (21) 9876-5432</p>
            <p><strong>Email:</strong> maria.oliveira@example.com</p>
        </div>

        <div class="location">
            <h2>Localização</h2>
            <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.9160195814363!2d-122.08424968468137!3d37.42199987982547!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fba8f989f5d8f%3A0xf12c0cf48804f716!2sGoogleplex!5e0!3m2!1spt-BR!2sbr!4v1608048665056!5m2!1spt-BR!2sbr" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Imobiliária Exemplo. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
