<?php

namespace App\Enums;

enum ScheduleStatus: string
{
    use EnumTrait;

    case NOT_REGISTERED = "not_registered";

    case NOT_SCHEDULED = "not_scheduled";

    case SCHEDULED = "scheduled";

    case VACCINATED = "vaccinated";

    case SCHEDULED_DATE_OVER = "scheduled_date_over";
}
