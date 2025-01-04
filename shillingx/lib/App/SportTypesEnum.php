<?php

namespace App;

enum SportTypesEnum: string
{
    case BAR_PULL_UPS = 'bar_pull_ups';
    case BAR_CHIN_UPS = 'bar_chin_ups';

    case ARMS_BARBELL_BICEPS = 'arms_barbell_biceps';
    case ARMS_DUMBBELL_BICEPS = 'arms_dumbbell_biceps';
    case ARMS_DUMBBELL_TRICEPS = 'arms_dumbbell_triceps';
    case ARMS_PUSH_UPS = 'arms_push_ups';

    case ABS_LEG_RAISE_OVER_KB = 'abs_leg_raise_over_kb';
    case ABS_LEG_RAISE_WITH_KB_HOLD = 'abs_leg_raise_with_kb_hold';
    case ABS_PLANK_HAND_TO_FOOT = 'abs_plank_hand_to_foot';
    case ABS_HANGING_OBLIQUE_CRUNCHES = 'abs_hanging_oblique_crunches';
    case ABS_RUSSIAN_TWISTS = 'abs_russian_twists';

    case SHOULDERS_KB_SHRUG = 'shoulders_kb_shrug';
    case SHOULDERS_KB_SINGLE_ARM_PRESS = 'shoulders_kb_single_arm_press';
    case SHOULDERS_KB_REAR_DELT_FLY = 'shoulders_kb_rear_delt_fly';
    case SHOULDERS_KB_LATERAL_RAISE = 'shoulders_kb_lateral_raise';
    case SHOULDERS_BARBELL_SQUAT = 'shoulders_barbell_squat';
    case SHOULDERS_BARBELL_DEADLIFT = 'shoulders_barbell_deadlift';
    case SHOULDERS_BARBELL_ROW = 'shoulders_barbell_row';
    case SHOULDERS_BARBELL_SHOULDER_PRESS = 'shoulders_barbell_shoulder_press';
    case SHOULDERS_BARBELL_BENCH_PRESS = 'shoulders_barbell_bench_press';
    case SHOULDERS_BARBELL_OVERHEAD_PRESS = 'shoulders_barbell_overhead_press';
    case SHOULDERS_BARBELL_OVERHEAD_PRESS_BACK = 'shoulders_barbell_overhead_press_back';

    case LEGS_WALKING_LUNGES = 'legs_walking_lunges';
    case LEGS_SQUAT_WITH_KB = 'legs_squat_with_kb';
    case LEGS_SQUAT = 'legs_squat';
    case LEGS_WALL_SITS = 'legs_wall_sits';
    case LEGS_CALVES = 'legs_calves';

    case CARDIO_WALK = 'cardio_walk';
    case CARDIO_SPRINTING = 'cardio_sprinting';
    case CARDIO_MOUNTAIN_CLIMBERS = 'cardio_mountain_climbers';
    case CARDIO_JUMPING_JACKS = 'cardio_jumping_jacks';
    case CARDIO_BICYCLE_CROSS_CRUNCHES = 'cardio_bicycle_cross_crunches';

    case FULL_BODY_KB_SWING_BOTH_HANDS = 'full_body_kb_swing_both_hands';
    case FULL_BODY_KB_SWING_SINGLE_HAND = 'full_body_kb_swing_single_hand';

    public function multiplier(): string
    {
        switch ($this) {
            case self::CARDIO_WALK:
                return 10;
            default:
                return 1;
        }
    }

    public function type(): string
    {
        switch ($this) {
            case self::CARDIO_WALK:
            case self::CARDIO_SPRINTING:
            case self::CARDIO_MOUNTAIN_CLIMBERS:
            case self::CARDIO_JUMPING_JACKS:
            case self::CARDIO_BICYCLE_CROSS_CRUNCHES:
                return 'min';
            default:
                return 'x';
        }
    }

    public function label(): string
    {
        return match ($this) {
            self::BAR_PULL_UPS => 'Bar: Pull Ups',
            self::BAR_CHIN_UPS => 'Bar: Chin Ups',

            self::ARMS_BARBELL_BICEPS => 'Arms: Barbell Bi-Ceps',
            self::ARMS_DUMBBELL_BICEPS => 'Arms: Dumbbell Bi-Ceps',
            self::ARMS_DUMBBELL_TRICEPS => 'Arms: Dumbbell Tri-Ceps',
            self::ARMS_PUSH_UPS=> 'Arms: Push-Ups',

            self::ABS_LEG_RAISE_OVER_KB => 'Abs: Leg Raise Over KB',
            self::ABS_LEG_RAISE_WITH_KB_HOLD => 'Abs: Leg Raise with KB Hold',
            self::ABS_PLANK_HAND_TO_FOOT => 'Abs: Plank Hand to Foot',
            self::ABS_HANGING_OBLIQUE_CRUNCHES => 'Abs: Hanging Oblique Crunches',
            self::ABS_RUSSIAN_TWISTS => 'Abs: Russian Twists',

            self::SHOULDERS_KB_SHRUG => 'Shoulders KB: Shrug',
            self::SHOULDERS_KB_SINGLE_ARM_PRESS => 'Shoulders KB: Single Arm Press',
            self::SHOULDERS_KB_REAR_DELT_FLY => 'Shoulders KB: Rear Delt Fly',
            self::SHOULDERS_KB_LATERAL_RAISE => 'Shoulders KB: Lateral Raise',
            self::SHOULDERS_BARBELL_SQUAT => 'Shoulders Barbell: Squat',
            self::SHOULDERS_BARBELL_DEADLIFT => 'Shoulders Barbell: Deadlift',
            self::SHOULDERS_BARBELL_ROW => 'Shoulders Barbell: Row',
            self::SHOULDERS_BARBELL_SHOULDER_PRESS => 'Shoulders Barbell: Shoulder Press',
            self::SHOULDERS_BARBELL_BENCH_PRESS => 'Shoulders Barbell: Bench Press',
            self::SHOULDERS_BARBELL_OVERHEAD_PRESS => 'Shoulders Barbell: Overhead Press',
            self::SHOULDERS_BARBELL_OVERHEAD_PRESS_BACK => 'Shoulders Barbell: Overhead Press Back',

            self::LEGS_WALKING_LUNGES => 'Legs: Walking Lunges',
            self::LEGS_SQUAT_WITH_KB => 'Legs: Squat with KB',
            self::LEGS_SQUAT => 'Legs: Squat',
            self::LEGS_WALL_SITS => 'Legs: Wall Sits',
            self::LEGS_CALVES => 'Legs: Calves',

            self::CARDIO_WALK => 'Cardio: Walk',
            self::CARDIO_SPRINTING => 'Cardio: Sprinting',
            self::CARDIO_MOUNTAIN_CLIMBERS => 'Cardio: Mountain Climbers',
            self::CARDIO_JUMPING_JACKS => 'Cardio: Jumping Jacks',
            self::CARDIO_BICYCLE_CROSS_CRUNCHES => 'Cardio: Bicycle Cross Crunches',

            self::FULL_BODY_KB_SWING_BOTH_HANDS => 'Full Body KB: Swing Both Hands',
            self::FULL_BODY_KB_SWING_SINGLE_HAND => 'Full Body KB: Swing Single Hand',
        };
    }
}
