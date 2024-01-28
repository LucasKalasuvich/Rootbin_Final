<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SignificantEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('significant_events')->insert([
            [
                'event' => 'Not a National Sentinel Event'
            ],
            [
                'event' => 'Haemolytic blood trandfusion reaction resulting from ABO incompability'
            ],
            [
                'event' => 'Infant abduction or Infant disacharged to wrong famiy'
            ],
            [
                'event' => 'Intravascular gas embolism resulting in death or neurogical damage'
            ],
            [
                'event' => 'Major permanent loss of function unrelated to the patient s natural course of ilness or underiying condition'
            ],
            [
                'event' => 'Maternal death or serious morbidity associated with labour and delivery'
            ],
            [
                'event' => 'Medication error leading to the death of a patient reasonabiy believed to be due to incorrect administration of drugs'
            ],
            [
                'event' => 'Rape workplace violence such as assault (leading to death or permanent lost) or homicide of a patient, staff member, practitioner, visitor or vendor while on hospital property.'
            ],
            [
                'event' => 'Retained instrument or other material after surgery reguiring re-operation or further surgical procedure'
            ],
            [
                'event' => 'Suicide'
            ],
            [
                'event' => 'Suicide in an inpatient unit'
            ],
            [
                'event' => '(Transmission of a chronic or fatal disease or ilness as a result of infusing blood or blood products'
            ],
            [
                'event' => 'Unanticipated death due unrelatad to the natural course of patient s iliness or underiying condition'
            ],
            [
                'event' => 'Unanticipated death of a ful-term infant'
            ],
            [
                'event' => 'Wrong-site, wrong-procedure, wong-patient surgery'
            ],
        ]);
    }
}
