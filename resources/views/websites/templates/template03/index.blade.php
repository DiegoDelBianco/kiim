<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venda de Imóvel</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }
        nav {
            background-color: #333;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 1rem;
            text-decoration: none;
        }
        .hero {
            background: url('hero-bg.jpg') no-repeat center center;
            background-size: cover;
            color: white;
            text-align: center;
            padding: 6rem 1rem;
        }
        .hero h1 {
            font-size: 3rem;
            margin: 0;
            color: #4CAF50
        }
        .container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .property-details, .contact-form, .seller-info, .faq {
            background-color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .property-details h2, .contact-form h2, .seller-info h2, .faq h2 {
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 0.5rem;
        }
        .property-details img {
            max-width: 100%;
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
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            position: relative;
            width: 100%;
        }
        .faq dt {
            font-weight: bold;
            margin-top: 1rem;
        }
        .faq dd {
            margin: 0 0 1rem 1rem;
        }
    </style>
</head>
<body>
    <nav>
        <a href="#property-details">Detalhes</a>
        <a href="#contact-form">Contato</a>
        <a href="#seller-info">Vendedor</a>
        <a href="#faq">FAQ</a>
    </nav>

    <div class="hero">
        <h1>Imóvel à Venda</h1>
    </div>

    <div class="container">
        <div id="property-details" class="property-details">
            <h2>Detalhes do Imóvel</h2>
            <p><strong>Endereço:</strong> Rua das Flores, 789, Bairro Exemplar, Cidade DEF</p>
            <p><strong>Preço:</strong> R$ 650.000,00</p>
            <p><strong>Descrição:</strong> Casa charmosa com 3 quartos, 2 banheiros, sala ampla, cozinha moderna, quintal com jardim e churrasqueira. Localização privilegiada perto de escolas e comércio.</p>
            <img src="https://img.freepik.com/fotos-gratis/villa-com-piscina-de-luxo-espetacular-design-contemporaneo-arte-digital-imoveis-casa-casa-e-propriedade-ge_1258-150749.jpg" alt="Imagem do imóvel">
        </div>

        <div id="contact-form" class="contact-form">
            <h2>Entre em Contato</h2>
            <form action="enviar_contato.php" method="post">
                <input type="text" name="name" placeholder="Nome" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="message" rows="4" placeholder="Mensagem" required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>

        <div id="seller-info" class="seller-info">
            <h2>Informações do Vendedor</h2>
            <p><strong>Nome:</strong> Pedro Santos</p>
            <p><strong>Telefone:</strong> (31) 91234-5678</p>
            <p><strong>Email:</strong> pedro.santos@example.com</p>
        </div>

        <div id="faq" class="faq">
            <h2>Perguntas Frequentes (FAQ)</h2>
            <dl>
                <dt>Qual é a área total do imóvel?</dt>
                <dd>A área total do imóvel é de 200m².</dd>
                <dt>O imóvel aceita financiamento?</dt>
                <dd>Sim, o imóvel aceita financiamento bancário.</dd>
                <dt>Há vaga de garagem?</dt>
                <dd>Sim, o imóvel possui garagem para 2 carros.</dd>
            </dl>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Imobiliária Exemplo. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
