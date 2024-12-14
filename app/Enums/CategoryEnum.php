<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumsTrait;

enum CategoryEnum: string
{
    use EnumsTrait;

    case SERMONS                 = 'Sermons';
    case MUSIC                   = 'Music';
    case VIDEOS                  = 'Videos';
    case DEVOTIONALS             = 'Devotionals';
    case BIBLE_STUDIES           = 'Bible Studies';
    case CHRISTIAN_LIVING        = 'Christian Living';
    case PRAYER_REFLECTION       = 'Prayer & Reflection';
    case EVENTS_ACTIVITIES       = 'Events & Activities';
    case TESTIMONIES             = 'Testimonies';
    case OUTREACH_EVANGELISM     = 'Outreach & Evangelism';
    case FAMILY_RELATIONSHIPS    = 'Family & Relationships';
    case THEOLOGY_DOCTRINE       = 'Theology & Doctrine';
    case CHRISTIAN_EDUCATION     = 'Christian Education';
    case HISTORICAL_CHRISTIANITY = 'Historical Christianity';
    case SPIRITUAL_GROWTH        = 'Spiritual Growth';
    case COUNSELING_SUPPORT      = 'Counseling & Support';
    case YOUTH_CHILDREN_MINISTRY = 'Youth & Children’s Ministry';
    case WORSHIP_PRACTICES       = 'Worship Practices';
    case SOCIAL_ISSUES_FAITH     = 'Social Issues & Faith';
    case ARTS_LITERATURE         = 'Arts & Literature';
}
