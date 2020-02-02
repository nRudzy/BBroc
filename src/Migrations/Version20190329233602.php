<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use phpDocumentor\Reflection\File;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190329233602 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE villesfr (ville_id INT AUTO_INCREMENT NOT NULL, ville_departement VARCHAR(3) DEFAULT NULL, ville_slug VARCHAR(255) DEFAULT NULL, ville_nom VARCHAR(45) DEFAULT NULL, ville_nom_simple VARCHAR(45) DEFAULT NULL, ville_nom_reel VARCHAR(45) DEFAULT NULL, ville_nom_soundex VARCHAR(20) DEFAULT NULL, ville_nom_metaphone VARCHAR(22) DEFAULT NULL, ville_code_postal VARCHAR(255) DEFAULT NULL, ville_commune VARCHAR(3) DEFAULT NULL, ville_code_commune VARCHAR(5) DEFAULT NULL, ville_arrondissement SMALLINT DEFAULT NULL, ville_canton VARCHAR(4) DEFAULT NULL, ville_amdi SMALLINT DEFAULT NULL, ville_population_2010 INT DEFAULT NULL, ville_population_1999 INT DEFAULT NULL, ville_population_2012 INT DEFAULT NULL, ville_densite_2010 INT DEFAULT NULL, ville_surface DOUBLE PRECISION DEFAULT NULL, ville_longitude_deg DOUBLE PRECISION DEFAULT NULL, ville_latitude_deg DOUBLE PRECISION DEFAULT NULL, ville_longitude_grd VARCHAR(9) NOT NULL, ville_latitude_grd VARCHAR(8) DEFAULT NULL, ville_longitude_dms VARCHAR(9) DEFAULT NULL, ville_latitude_dms VARCHAR(8) DEFAULT NULL, ville_zmin INT DEFAULT NULL, ville_zmax INT DEFAULT NULL, nom_departement VARCHAR(255) DEFAULT NULL, nom_region VARCHAR(255) DEFAULT NULL, PRIMARY KEY(ville_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql(file_get_contents('villes_france.sql',true));
        // 0
        $this->addSql('UPDATE villesfr SET nom_departement = "Ain" WHERE ville_departement = "01"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Aisne" WHERE ville_departement = "02"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Allier" WHERE ville_departement = "03"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Alpes-de-Haute-Provence" WHERE ville_departement = "04"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Hautes-Alpes" WHERE ville_departement = "05"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Alpes-maritimes" WHERE ville_departement = "06"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Ardèche" WHERE ville_departement = "07"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Ardennes" WHERE ville_departement = "08"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Ariège" WHERE ville_departement = "09"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Aube" WHERE ville_departement = "10"');
        // 10
        $this->addSql('UPDATE villesfr SET nom_departement = "Aude" WHERE ville_departement = "11"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Aveyron" WHERE ville_departement = "12"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Bouches-du-Rhône" WHERE ville_departement = "13"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Calvados" WHERE ville_departement = "14"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Cantal" WHERE ville_departement = "15"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Charente" WHERE ville_departement = "16"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Charente-maritime" WHERE ville_departement = "17"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Cher" WHERE ville_departement = "18"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Corrèze" WHERE ville_departement = "19"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Corse-du-Sud" WHERE ville_departement = "2A"');
        //20
        $this->addSql('UPDATE villesfr SET nom_departement = "Haute-Corse" WHERE ville_departement = "2B"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Côte-d-Or" WHERE ville_departement = "21"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Côtes-d-Armor" WHERE ville_departement = "22"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Creuse" WHERE ville_departement = "23"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Dordogne" WHERE ville_departement = "24"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Doubs" WHERE ville_departement = "25"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Drôme" WHERE ville_departement = "26"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Eure" WHERE ville_departement = "27"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Eure-et-Loir" WHERE ville_departement = "28"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Finistère" WHERE ville_departement = "29"');
        //30
        $this->addSql('UPDATE villesfr SET nom_departement = "Gard" WHERE ville_departement = "30"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Haute-garonne" WHERE ville_departement = "31"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Gers" WHERE ville_departement = "32"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Gironde" WHERE ville_departement = "33"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Hérault" WHERE ville_departement = "34"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Ille-et-Vilaine" WHERE ville_departement = "35"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Indre" WHERE ville_departement = "36"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Indre-et-Loire" WHERE ville_departement = "37"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Isère" WHERE ville_departement = "38"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Jura" WHERE ville_departement = "39"');
        //40
        $this->addSql('UPDATE villesfr SET nom_departement = "Landes" WHERE ville_departement = "40"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Loir-et-Cher" WHERE ville_departement = "41"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Loire" WHERE ville_departement = "42"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Haute-Loire" WHERE ville_departement = "43"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Loire-Atlantique" WHERE ville_departement = "44"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Loiret" WHERE ville_departement = "45"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Lot" WHERE ville_departement = "46"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Lot-et-Garonne" WHERE ville_departement = "47"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Lozère" WHERE ville_departement = "48"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Maine-et-Loire" WHERE ville_departement = "49"');
        //50
        $this->addSql('UPDATE villesfr SET nom_departement = "Manche" WHERE ville_departement = "50"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Marne" WHERE ville_departement = "51"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Haute-Marne" WHERE ville_departement = "52"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Mayenne" WHERE ville_departement = "53"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Meurthe-et-Moselle" WHERE ville_departement = "54"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Meuse" WHERE ville_departement = "55"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Morbihan" WHERE ville_departement = "56"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Moselle" WHERE ville_departement = "57"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Nièvre" WHERE ville_departement = "58"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Nord" WHERE ville_departement = "59"');
        //60
        $this->addSql('UPDATE villesfr SET nom_departement = "Oise" WHERE ville_departement = "60"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Orne" WHERE ville_departement = "61"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Pas-de-Calais" WHERE ville_departement = "62"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Puy-de-Dôme" WHERE ville_departement = "63"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Pyrénées-Atlantiques" WHERE ville_departement = "64"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Hautes-Pyrénées" WHERE ville_departement = "65"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Pyrénées-Orientales" WHERE ville_departement = "66"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Bas-Rhin" WHERE ville_departement = "67"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Haut-Rhin" WHERE ville_departement = "68"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Rhône" WHERE ville_departement = "69"');
        //70
        $this->addSql('UPDATE villesfr SET nom_departement = "Haute-Saône" WHERE ville_departement = "70"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Saône-et-Loire" WHERE ville_departement = "71"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Sarthe" WHERE ville_departement = "72"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Savoie" WHERE ville_departement = "73"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Haute-Savoie" WHERE ville_departement = "74"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Paris" WHERE ville_departement = "75"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Seine-Maritime" WHERE ville_departement = "76"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Seine-et-Marne" WHERE ville_departement = "77"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Yvelines" WHERE ville_departement = "78"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Deux-Sèvres" WHERE ville_departement = "79"');
        //80
        $this->addSql('UPDATE villesfr SET nom_departement = "Somme" WHERE ville_departement = "80"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Tarn" WHERE ville_departement = "81"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Tarn-et-Garonne" WHERE ville_departement = "82"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Var" WHERE ville_departement = "83"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Vaucluse" WHERE ville_departement = "84"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Vendée" WHERE ville_departement = "85"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Vienne" WHERE ville_departement = "86"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Haute-Vienne" WHERE ville_departement = "87"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Vosges" WHERE ville_departement = "88"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Yonne" WHERE ville_departement = "89"');
        //90
        $this->addSql('UPDATE villesfr SET nom_departement = "Territoire-de-Belfort" WHERE ville_departement = "90"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Essonne" WHERE ville_departement = "91"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Hauts-de-Seine" WHERE ville_departement = "92"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Seine-Saint-Denis" WHERE ville_departement = "93"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Val-de-Marne" WHERE ville_departement = "94"');
        //95
        //Outre mer
        $this->addSql('UPDATE villesfr SET nom_departement = "Val-d-Oise" WHERE ville_departement = "95"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Guadeloupe" WHERE ville_departement = "971"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Martinique" WHERE ville_departement = "972"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Guyane" WHERE ville_departement = "973"');
        $this->addSql('UPDATE villesfr SET nom_departement = "La-Réunion" WHERE ville_departement = "974"');
        $this->addSql('UPDATE villesfr SET nom_departement = "Mayotte" WHERE ville_departement = "976"');

        // add régions
        $this->addSql('UPDATE villesfr SET nom_region = "Alsace" WHERE ville_departement = "67"');
        $this->addSql('UPDATE villesfr SET nom_region = "Alsace" WHERE ville_departement = "68"');

        $this->addSql('UPDATE villesfr SET nom_region = "Aquitaine" WHERE ville_departement = "24"');
        $this->addSql('UPDATE villesfr SET nom_region = "Aquitaine" WHERE ville_departement = "33"');
        $this->addSql('UPDATE villesfr SET nom_region = "Aquitaine" WHERE ville_departement = "40"');
        $this->addSql('UPDATE villesfr SET nom_region = "Aquitaine" WHERE ville_departement = "47"');
        $this->addSql('UPDATE villesfr SET nom_region = "Aquitaine" WHERE ville_departement = "64"');

        $this->addSql('UPDATE villesfr SET nom_region = "Auvergne" WHERE ville_departement = "03"');
        $this->addSql('UPDATE villesfr SET nom_region = "Auvergne" WHERE ville_departement = "15"');
        $this->addSql('UPDATE villesfr SET nom_region = "Auvergne" WHERE ville_departement = "43"');
        $this->addSql('UPDATE villesfr SET nom_region = "Auvergne" WHERE ville_departement = "63"');

        $this->addSql('UPDATE villesfr SET nom_region = "Basse-Normandie" WHERE ville_departement = "14"');
        $this->addSql('UPDATE villesfr SET nom_region = "Basse-Normandie" WHERE ville_departement = "50"');
        $this->addSql('UPDATE villesfr SET nom_region = "Basse-Normandie" WHERE ville_departement = "61"');

        $this->addSql('UPDATE villesfr SET nom_region = "Bourgogne" WHERE ville_departement = "21"');
        $this->addSql('UPDATE villesfr SET nom_region = "Bourgogne" WHERE ville_departement = "58"');
        $this->addSql('UPDATE villesfr SET nom_region = "Bourgogne" WHERE ville_departement = "71"');
        $this->addSql('UPDATE villesfr SET nom_region = "Bourgogne" WHERE ville_departement = "89"');

        $this->addSql('UPDATE villesfr SET nom_region = "Bretagne" WHERE ville_departement = "22"');
        $this->addSql('UPDATE villesfr SET nom_region = "Bretagne" WHERE ville_departement = "29"');
        $this->addSql('UPDATE villesfr SET nom_region = "Bretagne" WHERE ville_departement = "35"');
        $this->addSql('UPDATE villesfr SET nom_region = "Bretagne" WHERE ville_departement = "56"');

        $this->addSql('UPDATE villesfr SET nom_region = "Centre" WHERE ville_departement = "18"');
        $this->addSql('UPDATE villesfr SET nom_region = "Centre" WHERE ville_departement = "28"');
        $this->addSql('UPDATE villesfr SET nom_region = "Centre" WHERE ville_departement = "36"');
        $this->addSql('UPDATE villesfr SET nom_region = "Centre" WHERE ville_departement = "37"');
        $this->addSql('UPDATE villesfr SET nom_region = "Centre" WHERE ville_departement = "41"');
        $this->addSql('UPDATE villesfr SET nom_region = "Centre" WHERE ville_departement = "45"');

        $this->addSql('UPDATE villesfr SET nom_region = "Champagne-Ardenne" WHERE ville_departement = "08"');
        $this->addSql('UPDATE villesfr SET nom_region = "Champagne-Ardenne" WHERE ville_departement = "10"');
        $this->addSql('UPDATE villesfr SET nom_region = "Champagne-Ardenne" WHERE ville_departement = "51"');
        $this->addSql('UPDATE villesfr SET nom_region = "Champagne-Ardenne" WHERE ville_departement = "52"');

        $this->addSql('UPDATE villesfr SET nom_region = "Corse" WHERE ville_departement = "2A"');
        $this->addSql('UPDATE villesfr SET nom_region = "Corse" WHERE ville_departement = "2B"');

        $this->addSql('UPDATE villesfr SET nom_region = "Dom-Tom" WHERE ville_departement = "971"');
        $this->addSql('UPDATE villesfr SET nom_region = "Dom-Tom" WHERE ville_departement = "972"');
        $this->addSql('UPDATE villesfr SET nom_region = "Dom-Tom" WHERE ville_departement = "973"');
        $this->addSql('UPDATE villesfr SET nom_region = "Dom-Tom" WHERE ville_departement = "974"');
        $this->addSql('UPDATE villesfr SET nom_region = "Dom-Tom" WHERE ville_departement = "976"');

        $this->addSql('UPDATE villesfr SET nom_region = "Franche-Compté" WHERE ville_departement = "25"');
        $this->addSql('UPDATE villesfr SET nom_region = "Franche-Compté" WHERE ville_departement = "39"');
        $this->addSql('UPDATE villesfr SET nom_region = "Franche-Compté" WHERE ville_departement = "70"');
        $this->addSql('UPDATE villesfr SET nom_region = "Franche-Compté" WHERE ville_departement = "90"');

        $this->addSql('UPDATE villesfr SET nom_region = "Haute-Normandie" WHERE ville_departement = "27"');
        $this->addSql('UPDATE villesfr SET nom_region = "Haute-Normandie" WHERE ville_departement = "76"');

        $this->addSql('UPDATE villesfr SET nom_region = "Ile-de-France" WHERE ville_departement = "75"');
        $this->addSql('UPDATE villesfr SET nom_region = "Ile-de-France" WHERE ville_departement = "77"');
        $this->addSql('UPDATE villesfr SET nom_region = "Ile-de-France" WHERE ville_departement = "78"');
        $this->addSql('UPDATE villesfr SET nom_region = "Ile-de-France" WHERE ville_departement = "91"');
        $this->addSql('UPDATE villesfr SET nom_region = "Ile-de-France" WHERE ville_departement = "92"');
        $this->addSql('UPDATE villesfr SET nom_region = "Ile-de-France" WHERE ville_departement = "93"');
        $this->addSql('UPDATE villesfr SET nom_region = "Ile-de-France" WHERE ville_departement = "94"');
        $this->addSql('UPDATE villesfr SET nom_region = "Ile-de-France" WHERE ville_departement = "95"');

        $this->addSql('UPDATE villesfr SET nom_region = "Languedoc-Roussilon" WHERE ville_departement = "11"');
        $this->addSql('UPDATE villesfr SET nom_region = "Languedoc-Roussilon" WHERE ville_departement = "30"');
        $this->addSql('UPDATE villesfr SET nom_region = "Languedoc-Roussilon" WHERE ville_departement = "34"');
        $this->addSql('UPDATE villesfr SET nom_region = "Languedoc-Roussilon" WHERE ville_departement = "48"');
        $this->addSql('UPDATE villesfr SET nom_region = "Languedoc-Roussilon" WHERE ville_departement = "66"');

        $this->addSql('UPDATE villesfr SET nom_region = "Limousin" WHERE ville_departement = "19"');
        $this->addSql('UPDATE villesfr SET nom_region = "Limousin" WHERE ville_departement = "23"');
        $this->addSql('UPDATE villesfr SET nom_region = "Limousin" WHERE ville_departement = "87"');

        $this->addSql('UPDATE villesfr SET nom_region = "Lorraine" WHERE ville_departement = "54"');
        $this->addSql('UPDATE villesfr SET nom_region = "Lorraine" WHERE ville_departement = "55"');
        $this->addSql('UPDATE villesfr SET nom_region = "Lorraine" WHERE ville_departement = "57"');
        $this->addSql('UPDATE villesfr SET nom_region = "Lorraine" WHERE ville_departement = "88"');

        $this->addSql('UPDATE villesfr SET nom_region = "Midi-Pyrénées" WHERE ville_departement = "09"');
        $this->addSql('UPDATE villesfr SET nom_region = "Midi-Pyrénées" WHERE ville_departement = "12"');
        $this->addSql('UPDATE villesfr SET nom_region = "Midi-Pyrénées" WHERE ville_departement = "31"');
        $this->addSql('UPDATE villesfr SET nom_region = "Midi-Pyrénées" WHERE ville_departement = "32"');
        $this->addSql('UPDATE villesfr SET nom_region = "Midi-Pyrénées" WHERE ville_departement = "46"');
        $this->addSql('UPDATE villesfr SET nom_region = "Midi-Pyrénées" WHERE ville_departement = "65"');
        $this->addSql('UPDATE villesfr SET nom_region = "Midi-Pyrénées" WHERE ville_departement = "81"');
        $this->addSql('UPDATE villesfr SET nom_region = "Midi-Pyrénées" WHERE ville_departement = "82"');

        $this->addSql('UPDATE villesfr SET nom_region = "Nord-Pas-de-Calais" WHERE ville_departement = "59"');
        $this->addSql('UPDATE villesfr SET nom_region = "Nord-Pas-de-Calais" WHERE ville_departement = "62"');

        $this->addSql('UPDATE villesfr SET nom_region = "Pays-de-la-Loire" WHERE ville_departement = "44"');
        $this->addSql('UPDATE villesfr SET nom_region = "Pays-de-la-Loire" WHERE ville_departement = "49"');
        $this->addSql('UPDATE villesfr SET nom_region = "Pays-de-la-Loire" WHERE ville_departement = "53"');
        $this->addSql('UPDATE villesfr SET nom_region = "Pays-de-la-Loire" WHERE ville_departement = "72"');
        $this->addSql('UPDATE villesfr SET nom_region = "Pays-de-la-Loire" WHERE ville_departement = "85"');

        $this->addSql('UPDATE villesfr SET nom_region = "Picardie" WHERE ville_departement = "02"');
        $this->addSql('UPDATE villesfr SET nom_region = "Picardie" WHERE ville_departement = "60"');
        $this->addSql('UPDATE villesfr SET nom_region = "Picardie" WHERE ville_departement = "80"');

        $this->addSql('UPDATE villesfr SET nom_region = "Poitou-Charentes" WHERE ville_departement = "16"');
        $this->addSql('UPDATE villesfr SET nom_region = "Poitou-Charentes" WHERE ville_departement = "17"');
        $this->addSql('UPDATE villesfr SET nom_region = "Poitou-Charentes" WHERE ville_departement = "79"');
        $this->addSql('UPDATE villesfr SET nom_region = "Poitou-Charentes" WHERE ville_departement = "86"');

        $this->addSql('UPDATE villesfr SET nom_region = "Provence-Alpes-Côtes-d-Azur" WHERE ville_departement = "04"');
        $this->addSql('UPDATE villesfr SET nom_region = "Provence-Alpes-Côtes-d-Azur" WHERE ville_departement = "06"');
        $this->addSql('UPDATE villesfr SET nom_region = "Provence-Alpes-Côtes-d-Azur" WHERE ville_departement = "13"');
        $this->addSql('UPDATE villesfr SET nom_region = "Provence-Alpes-Côtes-d-Azur" WHERE ville_departement = "05"');
        $this->addSql('UPDATE villesfr SET nom_region = "Provence-Alpes-Côtes-d-Azur" WHERE ville_departement = "83"');
        $this->addSql('UPDATE villesfr SET nom_region = "Provence-Alpes-Côtes-d-Azur" WHERE ville_departement = "84"');

        $this->addSql('UPDATE villesfr SET nom_region = "Rhône-Alpes" WHERE ville_departement = "01"');
        $this->addSql('UPDATE villesfr SET nom_region = "Rhône-Alpes" WHERE ville_departement = "07"');
        $this->addSql('UPDATE villesfr SET nom_region = "Rhône-Alpes" WHERE ville_departement = "26"');
        $this->addSql('UPDATE villesfr SET nom_region = "Rhône-Alpes" WHERE ville_departement = "38"');
        $this->addSql('UPDATE villesfr SET nom_region = "Rhône-Alpes" WHERE ville_departement = "42"');
        $this->addSql('UPDATE villesfr SET nom_region = "Rhône-Alpes" WHERE ville_departement = "69"');
        $this->addSql('UPDATE villesfr SET nom_region = "Rhône-Alpes" WHERE ville_departement = "73"');
        $this->addSql('UPDATE villesfr SET nom_region = "Rhône-Alpes" WHERE ville_departement = "74"');








    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE villesfr');
    }
}
