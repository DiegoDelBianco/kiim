<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venda de Imóvel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        .container {
            padding: 1rem;
        }
        .property-details, .contact-form, .seller-info {
            margin-bottom: 2rem;
        }
        .property-details h2, .contact-form h2, .seller-info h2 {
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 0.5rem;
        }
        .property-details img {
            max-width: 100%;
            height: auto;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 0.5rem;
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
        footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 1rem;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Imóvel à Venda</h1>
    </header>

    <div class="container">
        <div class="property-details">
            <h2>Detalhes do Imóvel</h2>
            <p><strong>Endereço:</strong> Rua Exemplo, 123, Bairro Modelo, Cidade ABC</p>
            <p><strong>Preço:</strong> R$ 500.000,00</p>
            <p><strong>Descrição:</strong> Imóvel espaçoso com 3 quartos, 2 banheiros, sala, cozinha, área de serviço e garagem para 2 carros. Próximo a escolas, supermercados e transporte público.</p>
            <img src="https://img.freepik.com/fotos-gratis/villa-com-piscina-de-luxo-espetacular-design-contemporaneo-arte-digital-imoveis-casa-casa-e-propriedade-ge_1258-150749.jpg" alt="Imagem do imóvel">
        </div>

        <div class="contact-form">
            <h2>Entre em Contato</h2>
            <form action="enviar_contato.php" method="post">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="message">Mensagem:</label>
                <textarea id="message" name="message" rows="4" required></textarea>
                
                <button type="submit">Enviar</button>
            </form>
        </div>

        <div class="seller-info">
            <h2>Informações do Vendedor</h2>
            <p><strong>Nome:</strong> João da Silva</p>
            <p><strong>Telefone:</strong> (11) 1234-5678</p>
            <p><strong>Email:</strong> joao.silva@example.com</p>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Imobiliária Exemplo. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
