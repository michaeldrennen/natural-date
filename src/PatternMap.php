<?php
namespace MichaelDrennen\NaturalDate;

use MichaelDrennen\NaturalDate\Exceptions\NoMatchingPatternFound;
use MichaelDrennen\NaturalDate\PatternModifiers\Early;
use MichaelDrennen\NaturalDate\PatternModifiers\Month;
use MichaelDrennen\NaturalDate\PatternModifiers\PatternModifier;
use MichaelDrennen\NaturalDate\PatternModifiers\Year;

class PatternMap {

    const early     = 'early';
    const late      = 'late';
    const beginning = 'beginning';
    const middle    = 'middle';
    const end       = 'end';
    const between   = 'between';
    const before    = 'before';
    const after     = 'after';

    const year  = 'year';
    const month = 'month';


    // I think I want to put classes or objects as the values in this array.
    // Those will tell the code what further processing to do on this string.
    protected $patterns = [
        PatternMap::early     => null,
        PatternMap::late      => null,
        PatternMap::beginning => null,
        PatternMap::middle    => null,
        PatternMap::end       => null,
        PatternMap::between   => null,
        PatternMap::before    => null,
        PatternMap::after     => null,

        PatternMap::year  => null,
        PatternMap::month => null,
    ];

    protected $patternModifiers = [
        PatternMap::early     => null,
        PatternMap::late      => null,
        PatternMap::beginning => null,
        PatternMap::middle    => null,
        PatternMap::end       => null,
        PatternMap::between   => null,
        PatternMap::before    => null,
        PatternMap::after     => null,

        PatternMap::year  => null,
        PatternMap::month => null,
    ];

    /**
     * @var string $matchedPattern The index from the $patterns array that matches the input string.
     */
    protected $matchedPatternLabel = null;


    /**
     * PrimaryPattern constructor.
     *
     * @param array $overridePatterns  Developer supplied array that allows new patterns to be added to NaturalDate at
     *                                 run time.
     *
     * @throws \Exception
     */
    public function __construct( array $overridePatterns ) {
        $this->initializePatternModifierObjects( $overridePatterns );
    }


    protected function initializePatternModifierObjects( array $overridePatterns ) {
        $this->patternModifiers = [
            PatternMap::early => new Early( $this->patterns[ PatternMap::early ] ),
            PatternMap::year  => new Year( $this->patterns[ PatternMap::year ] ),
            PatternMap::month => new Month( $this->patterns[ PatternMap::month ] ),
        ];

        foreach ( $overridePatterns as $pattern => $patternModifier ):
            $this->patterns[ $pattern ] = $patternModifier;
        endforeach;
    }

    /**
     * @param string $input
     *
     * @returns PatternModifier
     * @throws \MichaelDrennen\NaturalDate\Exceptions\NoMatchingPatternFound
     */
    public function setMatchedPattern( string $input ): PatternModifier {
        /**
         * @var \MichaelDrennen\NaturalDate\PatternModifiers\PatternModifier $patternModifier
         */
        foreach ( $this->patternModifiers as $label => $patternModifier ):
            $matched = $patternModifier->match( $input );
            if ( true === $matched ):
                $this->matchedPatternLabel = $label;
                return $patternModifier;
            endif;
        endforeach;
        throw new NoMatchingPatternFound( "No matching pattern found for input string: " . $input );
    }


}