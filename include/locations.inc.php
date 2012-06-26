<?php // Locations List

//////////////
// Mechs
//////////////

// Locations - Head only
$LocationHead = "<option value=\"H\">H</option>";

// Locations - Center Torso only
$LocationCT = "<option value=\"CT\">CT</option>";

// Locations - Heat Sinks
$LocationsHS .= "<option value=\"LT\">LT</option>";
$LocationsHS .= "<option value=\"RT\">RT</option>";
$LocationsHS .= "<option value=\"CT\">CT</option>";
$LocationsHS .= "<option value=\"LA\">LA</option>";
$LocationsHS .= "<option value=\"RA\">RA</option>";
$LocationsHS .= "<option value=\"LL\">LL</option>";
$LocationsHS .= "<option value=\"RL\">RL</option>";
$LocationsHS .= "<option value=\"H\">H</option>";

// Locations - Heat Sinks 2 Crits
$LocationsHS2 .= "<option value=\"LT\">LT</option>";
$LocationsHS2 .= "<option value=\"RT\">RT</option>";
$LocationsHS2 .= "<option value=\"CT\">CT</option>";
$LocationsHS2 .= "<option value=\"LA\">LA</option>";
$LocationsHS2 .= "<option value=\"RA\">RA</option>";
$LocationsHS2 .= "<option value=\"LL\">LL</option>";
$LocationsHS2 .= "<option value=\"RL\">RL</option>";

// Locations - Heat Sinks 3 Crits
$LocationsHS3 .= "<option value=\"LT\">LT</option>";
$LocationsHS3 .= "<option value=\"RT\">RT</option>";
$LocationsHS3 .= "<option value=\"LA\">LA</option>";
$LocationsHS3 .= "<option value=\"RA\">RA</option>";

// Locations - 1 Crits
$LocationsC1 .= "<option value=\"LT\">LT</option>";
$LocationsC1 .= "<option value=\"RT\">RT</option>";
$LocationsC1 .= "<option value=\"CT\">CT</option>";
$LocationsC1 .= "<option value=\"LA\">LA</option>";
$LocationsC1 .= "<option value=\"RA\">RA</option>";
$LocationsC1 .= "<option value=\"LL\">LL</option>";
$LocationsC1 .= "<option value=\"RL\">RL</option>";
$LocationsC1 .= "<option value=\"H\">H</option>";
$LocationsC1 .= "<option value=\"1\" disabled=\"disabled\">---</option>";
$LocationsC1 .= "<option value=\"LTR\">LTR</option>";
$LocationsC1 .= "<option value=\"RTR\">RTR</option>";
$LocationsC1 .= "<option value=\"CTR\">CTR</option>";
$LocationsC1 .= "<option value=\"LLR\">LLR</option>";
$LocationsC1 .= "<option value=\"RLR\">RLR</option>";
$LocationsC1 .= "<option value=\"HR\">HR</option>";

// Locations - 2 Crits
$LocationsC2 .= "<option value=\"LT\">LT</option>";
$LocationsC2 .= "<option value=\"RT\">RT</option>";
$LocationsC2 .= "<option value=\"CT\">CT</option>";
$LocationsC2 .= "<option value=\"LA\">LA</option>";
$LocationsC2 .= "<option value=\"RA\">RA</option>";
$LocationsC2 .= "<option value=\"LL\">LL</option>";
$LocationsC2 .= "<option value=\"RL\">RL</option>";
$LocationsC2 .= "<option value=\"1\" disabled=\"disabled\">---</option>";
$LocationsC2 .= "<option value=\"LTR\">LTR</option>";
$LocationsC2 .= "<option value=\"RTR\">RTR</option>";
$LocationsC2 .= "<option value=\"CTR\">CTR</option>";
$LocationsC2 .= "<option value=\"LLR\">LLR</option>";
$LocationsC2 .= "<option value=\"RLR\">RLR</option>";

// Locations - 3 Crits
$LocationsC3 .= "<option value=\"LT\">LT</option>";
$LocationsC3 .= "<option value=\"RT\">RT</option>";
$LocationsC3 .= "<option value=\"LA\">LA</option>";
$LocationsC3 .= "<option value=\"RA\">RA</option>";
$LocationsC3 .= "<option value=\"1\" disabled=\"disabled\">---</option>";
$LocationsC3 .= "<option value=\"LTR\">LTR</option>";
$LocationsC3 .= "<option value=\"RTR\">RTR</option>";

// Locations - L/R Torsos
$LocationsT .= "<option value=\"LT\">LT</option>";
$LocationsT .= "<option value=\"RT\">RT</option>";
$LocationsT .= "<option value=\"1\" disabled=\"disabled\">---</option>";
$LocationsT .= "<option value=\"LTR\">LTR</option>";
$LocationsT .= "<option value=\"RTR\">RTR</option>";

// Locations - Torsos
$LocationsTA .= "<option value=\"LT\">LT</option>";
$LocationsTA .= "<option value=\"RT\">RT</option>";
$LocationsTA .= "<option value=\"CT\">CT</option>";

// Locations - JumpJets
$LocationsJJ .= "<option value=\"LT\">LT</option>";
$LocationsJJ .= "<option value=\"RT\">RT</option>";
$LocationsJJ .= "<option value=\"CT\">CT</option>";
$LocationsJJ .= "<option value=\"LL\">LL</option>";
$LocationsJJ .= "<option value=\"RL\">RL</option>";

// Locations - Split Locations
$LocationsSP .= "<option value=\"LTLA\">LT/LA</option>";
$LocationsSP .= "<option value=\"RTRA\">RT/RA</option>";
$LocationsSP .= "<option value=\"LTCT\">LT/CT</option>";
$LocationsSP .= "<option value=\"RTCT\">RT/CT</option>";

//////////////
// Vehicles
//////////////

// Locations - Combat Vehicle
$LocationsGVT .= "<option value=\"Front\">F</option>";
$LocationsGVT .= "<option value=\"Left\">LS</option>";
$LocationsGVT .= "<option value=\"Right\">RS</option>";
$LocationsGVT .= "<option value=\"Rear\">R</option>";
$LocationsGVT .= "<option value=\"Turret\">T</option>";

// Locations - Combat Vehicle (no turret)
$LocationsGV .= "<option value=\"Front\">F</option>";
$LocationsGV .= "<option value=\"Left\">LS</option>";
$LocationsGV .= "<option value=\"Right\">RS</option>";
$LocationsGV .= "<option value=\"Rear\">R</option>";

// Locations - Combat Vehicle (internal/body only)
$LocationsGVI .= "<option value=\"Body\">B</option>";

//////////////
// Aerotech
//////////////

// Locations - Aerotech Fighter
$LocationsAF .= "<option value=\"Nose\">N</option>";
$LocationsAF .= "<option value=\"Left\">LW</option>";
$LocationsAF .= "<option value=\"Right\">RW</option>";
$LocationsAF .= "<option value=\"Aft\">A</option>";

// Locations - Aerotech Fighter (internal/body only)
$LocationsAFA .= "<option value=\"Body\">B</option>";

//////////////
// ProtoMech
//////////////

// Locations - ProtoMech (all)
$LocationsPM .= "<option value=\"MG\">MG</option>";
$LocationsPM .= "<option value=\"LA\">LA</option>";
$LocationsPM .= "<option value=\"RA\">RA</option>";
$LocationsPM .= "<option value=\"T\">T</option>";

// Locations - ProtoMech (torso)
$LocationsPMT .= "<option value=\"T\">T</option>";

//////////////
// Structures
//////////////

// Locations - Installation
$LocationsIT .= "<option value=\"North\">N</option>";
$LocationsIT .= "<option value=\"East\">E</option>";
$LocationsIT .= "<option value=\"West\">W</option>";
$LocationsIT .= "<option value=\"Turret\">T</option>";

// Locations - Installation (no turret)
$LocationsI .= "<option value=\"North\">N</option>";
$LocationsI .= "<option value=\"East\">E</option>";
$LocationsI .= "<option value=\"West\">W</option>";

?>