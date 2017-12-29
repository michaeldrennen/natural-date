<?php

namespace MichaelDrennen\NaturalDate\PatternModifiers;

use Carbon\Carbon;
use MichaelDrennen\NaturalDate\NaturalDate;

class Tomorrow extends PatternModifier {


    /**
     * @param \MichaelDrennen\NaturalDate\NaturalDate $naturalDate
     *
     * @return \MichaelDrennen\NaturalDate\NaturalDate
     * @throws \Exception
     */
    public function modify( NaturalDate $naturalDate ): NaturalDate {

        $start = Carbon::tomorrow( $naturalDate->getTimezoneId() );
        $end   = Carbon::tomorrow( $naturalDate->getTimezoneId() );

        $naturalDate->setStartYear( $start->year );
        $naturalDate->setStartMonth( $start->month );
        $naturalDate->setStartDay( $start->day );
        $naturalDate->setEndYear( $end->year );
        $naturalDate->setEndMonth( $end->month );
        $naturalDate->setEndDay( $end->day );
        $naturalDate->setStartTimesAsStartOfDay();
        $naturalDate->setEndTimesAsEndOfDay();
        $naturalDate->setType( NaturalDate::date );
        return $naturalDate;
    }
}