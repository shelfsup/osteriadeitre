<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAllergeniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergeni', function (Blueprint $table) {
            $table->id();
            $table->string('nome_italiano');
            $table->string('nome_inglese');
            $table->text('descrizione_italiano')->nullable();
            $table->text('descrizione_inglese')->nullable();
            $table->boolean('enable')->default(true);
            $table->timestamps();
        });

        // Insert default allergens
        DB::table('allergeni')->insert([
            [
                'nome_italiano' => 'Arachidi e derivati',
                'nome_inglese' => 'Peanuts and derivatives',
                'descrizione_italiano' => 'Snack confezionati, creme e condimenti in cui vi sia anche in piccole dosi',
                'descrizione_inglese' => 'Packaged snacks, creams, and condiments where even small amounts are present'
            ],
            [
                'nome_italiano' => 'Crostacei',
                'nome_inglese' => 'Crustaceans',
                'descrizione_italiano' => 'Marini e d\'Acqua Dolce: gamberi, scampi, aragoste, granchi, e simili',
                'descrizione_inglese' => 'Marine and Freshwater: shrimp, prawns, lobsters, crabs, and similar'
            ],
            [
                'nome_italiano' => 'Frutta a guscio',
                'nome_inglese' => 'Tree nuts',
                'descrizione_italiano' => 'Mandorle, nocciole, noci comuni, noci di acagiù, noci pecan, anacardi e pistacchi',
                'descrizione_inglese' => 'Almonds, hazelnuts, common nuts, cashew nuts, pecan nuts, cashews, and pistachios'
            ],
            [
                'nome_italiano' => 'Glutine',
                'nome_inglese' => 'Gluten',
                'descrizione_italiano' => 'Cereali, grano, segale, orzo, avena, farro, kamut, inclusi ibridati derivati',
                'descrizione_inglese' => 'Cereals, wheat, rye, barley, oats, spelt, kamut, including hybrid derivatives'
            ],
            [
                'nome_italiano' => 'Latte e derivati',
                'nome_inglese' => 'Milk and derivatives',
                'descrizione_italiano' => 'Ogni prodotto in cui viene usato il latte: yogurt, biscotti, torte, gelato e creme varie',
                'descrizione_inglese' => 'Every product that uses milk: yogurt, biscuits, cakes, ice cream, and various creams'
            ],
            [
                'nome_italiano' => 'Lupini',
                'nome_inglese' => 'Lupins',
                'descrizione_italiano' => 'Presenti in cibi vegan sottoforma di: arrosti, salamini, farine e similari',
                'descrizione_inglese' => 'Present in vegan foods in the form of: roasts, small sausages, flours, and similar'
            ],
            [
                'nome_italiano' => 'Molluschi',
                'nome_inglese' => 'Mollusks',
                'descrizione_italiano' => 'Canestrello, cannolicchio, capasanta, cozza, ostrica, patella, vongola, tellina ecc',
                'descrizione_inglese' => 'Scallop, razor clam, scallop, mussel, oyster, limpet, clam, wedge shell, etc.'
            ],
            [
                'nome_italiano' => 'Pesce',
                'nome_inglese' => 'Fish',
                'descrizione_italiano' => 'Prodotti alimentari in cui è presente il pesce, anche se in piccole percentuali',
                'descrizione_inglese' => 'Food products where fish is present, even in small percentages'
            ],
            [
                'nome_italiano' => 'Sesamo',
                'nome_inglese' => 'Sesame',
                'descrizione_italiano' => 'Semi interi usati per il pane, farine anche se lo contengono in minima percentuale',
                'descrizione_inglese' => 'Whole seeds used for bread, flours even if they contain it in minimal percentage'
            ],
            [
                'nome_italiano' => 'Senape',
                'nome_inglese' => 'Mustard',
                'descrizione_italiano' => 'Si può trovare nelle salse e nei condimenti, specie nella mostarda',
                'descrizione_inglese' => 'It can be found in sauces and condiments, especially mustard'
            ],
            [
                'nome_italiano' => 'Sedano',
                'nome_inglese' => 'Celery',
                'descrizione_italiano' => 'Sia in pezzi che all\'interno di preparati per zuppe, salse e concentrati vegetali',
                'descrizione_inglese' => 'Both in pieces and within preparations for soups, sauces, and vegetable concentrates'
            ],
            [
                'nome_italiano' => 'Soia',
                'nome_inglese' => 'Soy',
                'descrizione_italiano' => 'Prodotti derivati come: latte di soia, tofu, spaghetti di soia e simili',
                'descrizione_inglese' => 'Derived products such as: soy milk, tofu, soy spaghetti, and similar'
            ],
            [
                'nome_italiano' => 'Anidride solforosa e solfiti',
                'nome_inglese' => 'Sulfur dioxide and sulfites',
                'descrizione_italiano' => 'Cibi sott\'aceto, sott\'olio e in salamoia, marmellate, funghi secchi, conserve ecc',
                'descrizione_inglese' => 'Pickled, oil-packed, and brined foods, jams, dried mushrooms, preserves, etc.'
            ],
            [
                'nome_italiano' => 'Uova e derivati',
                'nome_inglese' => 'Eggs and derivatives',
                'descrizione_italiano' => 'Uova e prodotti che le contengono come: maionese, emulsionanti, pasta all\'uovo',
                'descrizione_inglese' => 'Eggs and products containing them such as: mayonnaise, emulsifiers, egg pasta'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allergeni');
    }
}
