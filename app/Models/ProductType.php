<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
}

/*
Imóvel a venda
Aluguel
Financiamento
Consórcio
Emprestimo com garantia
Serviços Imobiliários
Outros

INSERT INTO `product_types` ( `name`) VALUES ('Imóvel a venda');
INSERT INTO `product_types` ( `name`) VALUES ('Aluguel');
INSERT INTO `product_types` ( `name`) VALUES ('Financiamento');
INSERT INTO `product_types` ( `name`) VALUES ('Consórcio');
INSERT INTO `product_types` ( `name`) VALUES ('Emprestimo com garantia');
INSERT INTO `product_types` ( `name`) VALUES ('Serviços Imobiliários');
INSERT INTO `product_types` ( `name`) VALUES ('Outros');
*/
