<div>
    <h2>Job Summary</h2>
    <p>{{ $jobSummary }}</p>
    @if (count($benefits) > 0)
        <h2>Benefits</h2>
        <ul>
            @foreach ($benefits as $benefit)
                <li>{{ $benefit }}</li>
            @endforeach
        </ul>
    @endif
    @if (count($qualifications) > 0)
        <h2>Qualifications</h2>
        <ul>
            @foreach ($qualifications as $qualification)
                <li>{{ $qualification }}</li>
            @endforeach
        </ul>
    @endif
    @if (count($responsibilities) > 0)
        <h2>Responsibilities</h2>
        <ul>
            @foreach ($responsibilities as $responsibility)
                <li>{{ $responsibility }}</li>
            @endforeach
        </ul>
    @endif
    @if (count($skills) > 0)
        <h2>Skills</h2>
        <ul>
            @foreach ($skills as $skill)
                <li>{{ $skill['text'] }}</li>
            @endforeach
        </ul>
    @endif
</div>
