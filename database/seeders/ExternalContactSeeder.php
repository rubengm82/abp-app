<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExternalContact;

class ExternalContactSeeder extends Seeder
{
    public function run(): void
    {
        $externalContacts = [
            [
                'external_contact_type' => 'Servei Social',
                'service_reason' => 'Atenció a famílies en situació de risc',
                'company' => 'Serveis Socials de Barcelona',
                'department' => 'Atenció a la Infància i Adolescència',
                'name' => 'Montserrat',
                'surname' => 'García',
                'link' => 'https://ajuntament.barcelona.cat/serveissocials',
                'phone' => '+34 933 123 456',
                'email' => 'montserrat.garcia@bcn.cat',
                'observations' => 'Contacte principal per a derivacions de casos familiars. Disponible de dilluns a divendres de 9h a 14h.',
            ],
            [
                'external_contact_type' => 'Salut Mental',
                'service_reason' => 'Avaluació i seguiment psicològic',
                'company' => 'Centre de Salut Mental Infantil i Juvenil',
                'department' => 'Unitat d\'Adolescents',
                'name' => 'Jordi',
                'surname' => 'Martínez',
                'link' => 'https://salutmental.cat',
                'phone' => '+34 933 234 567',
                'email' => 'jordi.martinez@salutmental.cat',
                'observations' => 'Especialista en trastorns de conducta en adolescents. Cita prèvia necessària.',
            ],
            [
                'external_contact_type' => 'Justícia',
                'service_reason' => 'Seguiment de mesures judicials',
                'company' => 'Jutjat de Menors',
                'department' => 'Equip Tècnic',
                'name' => 'Cristina',
                'surname' => 'López',
                'link' => null,
                'phone' => '+34 933 345 678',
                'email' => 'cristina.lopez@justicia.es',
                'observations' => 'Responsable del seguiment de mesures en medi obert. Informes mensuals requerits.',
            ],
            [
                'external_contact_type' => 'Educació',
                'service_reason' => 'Coordinació amb centres educatius',
                'company' => 'Institut d\'Educació Secundària Joan Boscà',
                'department' => 'Orientació',
                'name' => 'Albert',
                'surname' => 'Fernández',
                'link' => 'https://iesjoanbosca.cat',
                'phone' => '+34 933 456 789',
                'email' => 'albert.fernandez@iesjoanbosca.cat',
                'observations' => 'Orientador del centre. Coordinació per a seguiment acadèmic dels joves.',
            ],
            [
                'external_contact_type' => 'Formació i Ocupació',
                'service_reason' => 'Inserció laboral i formació professional',
                'company' => 'Servei d\'Ocupació de Catalunya',
                'department' => 'Joves',
                'name' => 'Laura',
                'surname' => 'Torres',
                'link' => 'https://soc.gencat.cat',
                'phone' => '+34 933 567 890',
                'email' => 'laura.torres@soc.gencat.cat',
                'observations' => 'Tècnica d\'inserció laboral. Ofereix programes de formació i pràctiques empresarials.',
            ],
            [
                'external_contact_type' => 'Salut',
                'service_reason' => 'Atenció sanitària i seguiment mèdic',
                'company' => 'Centre d\'Atenció Primària',
                'department' => 'Medicina Familiar',
                'name' => 'Dr. Pere',
                'surname' => 'Sánchez',
                'link' => null,
                'phone' => '+34 933 678 901',
                'email' => 'pere.sanchez@catsalut.cat',
                'observations' => 'Metge de referència per a joves del centre. Consultes amb cita prèvia.',
            ],
            [
                'external_contact_type' => 'Servei Social',
                'service_reason' => 'Recursos d\'allotjament i habitatge',
                'company' => 'Fundació Habitatge Social',
                'department' => 'Joves',
                'name' => 'Marta',
                'surname' => 'Domènech',
                'link' => 'https://habitatgesocial.cat',
                'phone' => '+34 933 789 012',
                'email' => 'marta.domenech@habitatgesocial.cat',
                'observations' => 'Gestió de pisos tutelats i recursos d\'allotjament per a joves emancipats.',
            ],
            [
                'external_contact_type' => 'Associació',
                'service_reason' => 'Activitats de lleure i participació',
                'company' => 'Associació de Joves del Barri',
                'department' => null,
                'name' => 'Oriol',
                'surname' => 'Prats',
                'link' => 'https://jovesbarri.cat',
                'phone' => '+34 933 890 123',
                'email' => 'oriol.prats@jovesbarri.cat',
                'observations' => 'Organitza activitats de lleure i esport per a joves. Col·laboració en projectes comunitaris.',
            ],
            [
                'external_contact_type' => 'Justícia',
                'service_reason' => 'Mediació familiar',
                'company' => 'Servei de Mediació Familiar',
                'department' => 'Mediació',
                'name' => 'Núria',
                'surname' => 'Roca',
                'link' => null,
                'phone' => '+34 933 901 234',
                'email' => 'nuria.roca@mediacio.cat',
                'observations' => 'Mediadora familiar. Intervé en conflictes familiars i processos de separació.',
            ],
            [
                'external_contact_type' => 'Formació i Ocupació',
                'service_reason' => 'Formació professional i qualificació',
                'company' => 'Centre de Formació Professional',
                'department' => 'Inserció',
                'name' => 'Sergi',
                'surname' => 'Carreras',
                'link' => 'https://cfp.cat',
                'phone' => '+34 933 012 345',
                'email' => 'sergi.carreras@cfp.cat',
                'observations' => 'Coordinador de programes de formació professional. Ofertes de cursos i qualificació.',
            ],
            [
                'external_contact_type' => 'Salut Mental',
                'service_reason' => 'Atenció en addiccions',
                'company' => 'Centre d\'Atenció i Seguiment a les Drogodependències',
                'department' => 'Prevenció i Tractament',
                'name' => 'Clara',
                'surname' => 'Vilaseca',
                'link' => 'https://casd.cat',
                'phone' => '+34 933 123 789',
                'email' => 'clara.vilaseca@casd.cat',
                'observations' => 'Tècnica en addiccions. Suport per a joves amb problemes de consum de substàncies.',
            ],
            [
                'external_contact_type' => 'Educació',
                'service_reason' => 'Suport educatiu especialitzat',
                'company' => 'Equip d\'Assessorament Psicopedagògic',
                'department' => 'Necessitats Educatives Especials',
                'name' => 'Paula',
                'surname' => 'Moreno',
                'link' => 'https://eap.cat',
                'phone' => '+34 933 234 890',
                'email' => 'paula.moreno@eap.cat',
                'observations' => 'Psicopedagoga especialitzada en necessitats educatives especials. Avaluacions i suport.',
            ],
        ];

        // Delete all existing records
        ExternalContact::query()->delete();

        // Create external contacts
        foreach ($externalContacts as $contact) {
            ExternalContact::create($contact);
        }
    }
}

