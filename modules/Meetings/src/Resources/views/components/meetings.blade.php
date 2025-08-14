@php
    $startOfMonth = $startDate->copy()->startOfMonth();
    $endOfMonth = $startDate->copy()->endOfMonth();
    $startDay = $startOfMonth->dayOfWeek;
    $daysInMonth = $startOfMonth->daysInMonth;
    $today = now()->day;
    $currentMonth = $startDate->month;
    $currentYear = $startDate->year;
    $isCurrentMonth = (now()->month == $currentMonth && now()->year == $currentYear);
@endphp

<!-- Previous month days (empty) -->
@for($i = 0; $i < $startDay; $i++)
    <div class="h-32 p-1 bg-gray-50 text-gray-400"></div>
@endfor

<!-- Current month days -->
@for($day = 1; $day <= $daysInMonth; $day++)
    <div class="h-auto p-1 relative calendar-day @if($isCurrentMonth && $day == $today) today @endif">
        <div class="text-right p-1 date-number @if($isCurrentMonth && $day == $today) bg-blue-100 text-blue-600 border rounded-lg @endif">{{ $day }}</div>
        <div class="space-y-1 overflow-y-auto max-h-24">
            @if(isset($meetings[$day]))
                @foreach($meetings[$day]->take(3) as $meeting)
                    <a href="{{ route('admin.meetings.show', $meeting->id) }}" 
                    class="block text-xs p-1 bg-{{ $meeting->color ?? 'green' }}-100 text-{{ $meeting->color ?? 'green' }}-800 rounded truncate hover:bg-{{ $meeting->color ?? 'green' }}-200 meeting-item"
                    title="{{ $meeting->title }} ({{ $meeting->start_time 
    ? \Carbon\Carbon::parse($meeting->start_time)->format('g:i A') 
    : 'Not Scheduled'; }})">
                        {{ $meeting->title }}
                    </a>
                @endforeach
                
                @if($meetings[$day]->count() >= 3)
                    @php
                        $date = \Carbon\Carbon::create(
                            $currentYear,
                            $currentMonth,
                            $day
                        )->format('Y-m-d');
                    @endphp
                    <a href="{{ route('admin.meetings.list') }}?filters[start_time][0][0]={{$date}}&filters[start_time][0][1]={{$date}}" 
                    class="block text-xs text-center text-blue-600 hover:text-blue-800 hover:underline mt-1">
                        + {{ $meetings[$day]->count() - 3 }} more meetings
                    </a>
                @endif
            @endif
        </div>
    </div>
@endfor

<!-- Next month days (empty) -->
@php
    $totalCells = 42; // 6 weeks
    $filledCells = $startDay + $daysInMonth;
    $remainingCells = $totalCells - $filledCells;
@endphp
@for($i = 0; $i < $remainingCells; $i++)
    <div class="h-32 p-1 bg-gray-50 text-gray-400"></div>
@endfor