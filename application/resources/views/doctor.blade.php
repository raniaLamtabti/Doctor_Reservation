@extends('layouts.app')

@section('content')

<main class="doctor">

    <section class="container informations ">
        <div class="information">
        <div class="image">
            <img src="{{ asset($doctor->image) }}" alt="">
        </div>
        <div class="content">
            <h1>Dr. {{ $doctor->name }}</h1>
            <span>{{ App\Models\Specialty::find($doctor->specialty_id)->name }}</span>
            <p>{{ $doctor->description }}</p>
            <ul>
                <li>
                    <div class="imageI">
                        <img src="{{ asset('images/Icon awesome-phone-alt.png') }}" alt="">
                    </div>
                    <p>{{ $doctor->phone }}</p>
                </li>
                <li>
                    <div class="imageI">
                        <img src="{{ asset('images/Icon material-mail.png') }}" alt="">
                    </div>
                    <p>{{ $doctor->email }}</p>
                </li>
                <li>
                    <div class="imageI">
                        <img src="{{ asset('images/Icon material-location-on2.png') }}" alt="">
                    </div>
                    <p>{{ App\Models\City::find($doctor->city_id)->name }}, {{ $doctor->location }}</p>
                </li>
            </ul>
        </div>
    </div>
    </section>

    {{-- {{ $name = $doctor->name }} --}}
    <section class="appointment container">
            <div class="content">
                <div class="calendar">
                    <div class="calendar-header">
                        <span class="month-picker" id="month-picker">February</span>
                        <div class="year-picker">
                            <span class="year-change" id="prev-year">
                                <pre><</pre>
                            </span>
                            <span id="year">2021</span>
                            <span class="year-change" id="next-year">
                                <pre>></pre>
                            </span>
                        </div>
                    </div>
                    <div class="calendar-body">
                        <div class="calendar-week-day">
                            <div>Sun</div>
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                        </div>
                        <div class="calendar-days"></div>
                    </div>
                    <div class="month-list"></div>
                </div>
                <div class="line"></div>
                <div class="hours">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-morning-tab" data-bs-toggle="pill" data-bs-target="#pills-morning" type="button" role="tab" aria-controls="pills-morning" aria-selected="true">Morning</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-afternoon-tab" data-bs-toggle="pill" data-bs-target="#pills-afternoon" type="button" role="tab" aria-controls="pills-afternoon" aria-selected="false">Afternoon</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-evening-tab" data-bs-toggle="pill" data-bs-target="#pills-evening" type="button" role="tab" aria-controls="pills-evening" aria-selected="false">Evening</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-morning" role="tabpanel" aria-labelledby="pills-morning-tab">
                        </div>
                        <div class="tab-pane fade" id="pills-afternoon" role="tabpanel" aria-labelledby="pills-afternoon-tab">
                        </div>
                        <div class="tab-pane fade" id="pills-evening" role="tabpanel" aria-labelledby="pills-evening-tab">
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('user.createReservation') }}" method="post">
                @csrf
                <input type="text" name="doctor" hidden value="{{ $doctor->id }}">
                <input type="hidden" name="date" id="dateI">
                <input type="time" hidden name="time" id="timeI">
                <div class="btnSub">
                    <button type="submit">apllay</button>
                </div>
            </form>
        </section>
        <section class="map">
            <img src="{{ asset('images/Rectangle 34.png') }}" alt="" width="100%" height="500%" style="margin-bottom: 100px">
        </section>


</main>

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $doctor->name }}</div>
                <div class="card-body">
                    {{ $doctor->phone }}
                    {{ $doctor->city }}
                    {{ $doctor->location }}
                    {{ $doctor->description }}
                    <a href="{{ route('show', ['id' => $doctor->id]) }}">Appointment</a>
                </div>
            </div>
        </div>
    </div>
    @foreach ($uptimes as $uptime)
    {{ $uptime->days }}
        @foreach(explode('|', $uptime->days) as $day)
        <option>{{$day}}</option>
        @endforeach
    @endforeach

    @foreach ($vacations as $vacation)
    {{ $vacation->start }}
    {{ $vacation->end }}
    @endforeach

    <form action="{{ route('user.createReservation') }}" method="post">
        @csrf
        <input type="text" name="doctor" hidden value="{{ $doctor->id }}">
        <input type="date" name="date">
        <input type="time" name="time">
        <button type="submit">apllay</button>
    </form>
</div> --}}
@endsection

@section('scripts')
<script>
    let calendar = document.querySelector('.calendar')

    const month_names = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']

    isLeapYear = (year) => {
        return (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) || (year % 100 === 0 && year % 400 ===0)
    }

    getFebDays = (year) => {
        return isLeapYear(year) ? 29 : 28
    }

    generateCalendar = (month, year) => {

        let calendar_days = calendar.querySelector('.calendar-days')
        let calendar_header_year = calendar.querySelector('#year')

        let days_of_month = [31, getFebDays(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]

        calendar_days.innerHTML = ''

        let currDate = new Date()
        if (!month) month = currDate.getMonth()
        if (!year) year = currDate.getFullYear()

        let curr_month = `${month_names[month]}`
        month_picker.innerHTML = curr_month
        calendar_header_year.innerHTML = year

        // get first day of month

        let first_day = new Date(year, month, 1)

        for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {
            let day = document.createElement('input')
            if (i >= first_day.getDay()) {
                day.classList.add('calendar-day-hover')
                var dayA = i - first_day.getDay() + 1
                switch (curr_month) {
                    case "January":
                        month = 1;
                        break;
                    case "February":
                        month = 2;
                        break;
                    case "March":
                        month = 3;
                        break;
                    case "April":
                        month = 4;
                        break;
                    case "May":
                        month = 5;
                        break;
                    case "June":
                        month = 6;
                    case "July":
                        month = 7;
                        break;
                    case "August":
                        month = 8;
                        break;
                    case "September":
                        month = 9;
                        break;
                    case "October":
                        month = 10;
                        break;
                    case "November":
                        month = 11;
                        break;
                    case "December":
                        month = 12;
                }
                day.placeholder = dayA
                day.setAttribute("id", year + '-' + month + '-' + dayA)
                day.readOnly = true
                day.classList.add('dayT')
                if (i - first_day.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() && month === currDate.getMonth() + 1) {
                    day.classList.add('curr-date')
                }
            }
            calendar_days.appendChild(day)
        }
    }

    let month_list = calendar.querySelector('.month-list')

    month_names.forEach((e, index) => {
        let month = document.createElement('div')
        month.innerHTML = `<div data-month="${index}">${e}</div>`
        month.querySelector('div').onclick = () => {
            month_list.classList.remove('show')
            curr_month.value = index
            generateCalendar(index, curr_year.value)
        }
        month_list.appendChild(month)
    })

    let month_picker = calendar.querySelector('#month-picker')

    month_picker.onclick = () => {
        month_list.classList.add('show')
    }

    let currDate = new Date()

    let curr_month = {value: currDate.getMonth()}
    let curr_year = {value: currDate.getFullYear()}

    generateCalendar(curr_month.value, curr_year.value)

    document.querySelector('#prev-year').onclick = () => {
        --curr_year.value
        generateCalendar(curr_month.value, curr_year.value)
    }

    document.querySelector('#next-year').onclick = () => {
        ++curr_year.value
        generateCalendar(curr_month.value, curr_year.value)
    }

    let daysT = document.querySelectorAll('.dayT')
    daysT.forEach(day => {
        day.addEventListener('click', event => {
            [...day.parentElement.children].forEach(sib => sib.classList.remove('dayTC'))
            day.classList.add('dayTC')
            day.setAttribute("title", 'ok')
            var date = day.id
            var d = new Date(date);
            var dayNumber = d.getDay();
            var uptimes =  {!! json_encode($uptimes, JSON_HEX_TAG) !!};
            var morning = document.querySelector('#pills-morning')
            var afternoon = document.querySelector('#pills-afternoon')
            var evening = document.querySelector('#pills-evening')
            var dateI = document.querySelector('#dateI')
            dateI.value = date
            var index = uptimes.findIndex(x => {
                let str = x.days;
                const myArr = str.split("|");
                if(myArr.find(element => element = dayNumber)){
                    return true;
                }
            });
            if(index >= 0){
                var date = uptimes[index].morningFrom
                const currentDate = new Date(date);
                var hr = currentDate.getHours() - 1
                var mn = currentDate.getMinutes()
                var hrC = String.valueOf(hr).length;
                var mnC = String.valueOf(mn).length;
                if(hrC == 1){
                    var hour = "0" + hr;
                }
                if(mnC == 1){
                    var min = mn + '0'
                }
                if(mn>0){
                    mn = 0.5;
                }
                var dateT = uptimes[index].morningTo
                const currentDateT = new Date(dateT);
                var hrT = currentDateT.getHours() - 1
                var mnT = currentDateT.getMinutes()
                if(mnT>0){
                    mnT = 0.5;
                }
                let day = document.createElement('div')
                var timeF = hr + mn
                var timeT = hrT + mnT

                for(var i = timeF; i < timeT; i = i + 0.5){
                    minutes = 0
                    if(!Number.isInteger(i)){
                        hour = i - 0.5
                        hour = hour.toLocaleString('en-US', {
                            minimumIntegerDigits: 2,
                            useGrouping: false
                        })
                        minutes = 30
                    }
                    if(minutes==0){
                        minutes = minutes.toLocaleString('en-US', {
                            minimumIntegerDigits: 2,
                            useGrouping: false
                        })
                    }
                    day.innerHTML+= `<input type="radio" id="time` + i + `" name="timeG" class="form-check-input timeG" value="` + hour + ':' + minutes +`">
                                    <label class="form-check-label" for="time` + i + `" class="timeL">
                                        <div class="icon">
                                            <img src="{{ asset('images/Icon material-done.png') }}" alt="">
                                        </div>
                                        ` + hour + ':' + minutes +`
                                    </label>`
                }
                morning.innerHTML  = ''
                morning.appendChild(day)

                var dateEF = uptimes[index].eveningFrom
                const currentDateE = new Date(dateEF);
                var hrE = currentDateE.getHours() - 1
                var mnE = currentDateE.getMinutes()
                if(mnE>0){
                    mnE = 0.5;
                }
                var dateET = uptimes[index].eveningTo
                const currentDateTE = new Date(dateET);
                var hrET = currentDateTE.getHours() - 1
                var mnET = currentDateTE.getMinutes()
                if(mnET>0){
                    mnET = 0.5;
                }
                let dayE = document.createElement('div')
                var timeFE = hrE + mnE
                var timeTE = hrET + mnET
                var hourE = hrE
                for(var ie = timeFE; ie < timeTE; ie = ie + 0.5){
                    console.log(ie)
                    minutesE = 0
                    if(!Number.isInteger(ie)){
                        console.log(ie)
                        hourE= ie - 0.5
                        hourE= hourE.toLocaleString('en-US', {
                            minimumIntegerDigits: 2,
                            useGrouping: false
                        })
                        minutesE = 30
                        console.log(hourE);
                    }
                    if(minutesE==0){
                        minutesE = minutesE.toLocaleString('en-US', {
                            minimumIntegerDigits: 2,
                            useGrouping: false
                        })
                    }
                    dayE.innerHTML+= `<input type="radio" id="time` + ie + `" name="timeG" class="form-check-input timeG" value="` + hourE+ ':' + minutesE +`">
                                    <label class="form-check-label" for="time` + ie + `" class="timeL">
                                        <div class="icon">
                                            <img src="{{ asset('images/Icon material-done.png') }}" alt="">
                                        </div>
                                        ` + hourE+ ':' + minutesE +`
                                    </label>`
                }
                evening.innerHTML  = ''
                evening.appendChild(dayE)

                var dateAF = uptimes[index].afternoonFrom
                const currentDateA = new Date(dateAF);
                var hrA = currentDateA.getHours() - 1
                var mnA = currentDateA.getMinutes()
                if(mnA>0){
                    mnA = 0.5;
                }
                var dateAT = uptimes[index].afternoonTo
                const currentDateTA = new Date(dateAT);
                var hrAT = currentDateTA.getHours() - 1
                var mnAT = currentDateTA.getMinutes()
                if(mnAT>0){
                    mnAT = 0.5;
                }
                let dayA = document.createElement('div')
                var timeFA = hrA + mnA
                var timeTA = hrAT + mnAT
                var hourA = hrA
                for(var ia = timeFA; ia < timeTA; ia = ia + 0.5){
                    console.log(ia)
                    minutesA = 0
                    if(!Number.isInteger(ia)){
                        console.log(ia)
                        hourA= ia - 0.5
                        hourA= hourA.toLocaleString('en-US', {
                            minimumIntegerDigits: 2,
                            useGrouping: false
                        })
                        minutesA = 30
                        console.log(hourA);
                    }
                    if(minutesA==0){
                        minutesA = minutesA.toLocaleString('en-US', {
                            minimumIntegerDigits: 2,
                            useGrouping: false
                        })
                    }
                    dayA.innerHTML+= `<input type="radio" id="time` + ia + `" name="timeG" class="form-check-input timeG" value="` + hourA+ ':' + minutesA +`">
                                    <label class="form-check-label" for="time` + ia + `" class="timeL">
                                        <div class="icon">
                                            <img src="{{ asset('images/Icon material-done.png') }}" alt="">
                                        </div>
                                        ` + hourA+ ':' + minutesA +`
                                    </label>`
                }
                afternoon.innerHTML  = ''
                afternoon.appendChild(dayA)

                var timeI = document.querySelector('#timeI')
                let timeG = document.querySelectorAll('.timeG')
                console.log(timeG);
                    timeG.forEach(item => {
                        item.addEventListener('change', event => {
                        timeI.value = item.value
                    })
                });
            }
        })
    })


    // timeL.forEach(item => {
    //     item.addEventListener('click', event => {
    //         console.log(item);
    //         alert('You clicked radio!');
    //     })
    // });
    // timeG.forEach(item => {
    //     item.addEventListener('onchange', event => {
    //         console.log(item);
    //         alert('You clicked radio!');
    //     })
    // });
</script>
@endsection
