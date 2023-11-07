@extends('layouts.app')
@section('content')
<div class="container">
	<div class="main container-fluid">
    <div class="card-header w-100">求人ID{{$jobOfferId}}の編集ログ一覧</div>
    <div class="table_wrap" style="overflow: auto; max-height: 400px;">
        @if (count($jobOfferHistories)>0)
        <table class="table table-bordered table-hover w-100" style="overflow-x: auto; white-space: nowrap; margin-bottom: 0;">
            <thead>
            <tr class=m-auto style="background-color: lightgray">
                <th>更新日</th>
                <th>編集者</th>
                <th>項目名</th>
                <th>編集前</th>
                <th>編集後</th>
            </tr>
            </thead>

            @foreach($jobOfferHistories as $jobOfferHistory)
                <?php $num = 0 ?>
                @foreach($jobOfferHistory->updated_content as $key => $record)
                    @if($record['after'] != $record['before'])
                        <?php $num++ ?>
                    @endif
                @endforeach
                <?php $count = 0 ?>
                @foreach($jobOfferHistory->updated_content as $key => $record)
                    <?php
                    $recordBefore = 'before';
                    $recordAfter  = 'after';
                    ?>
                    @if ($key == 'long_vacation' || $key == 'holiday')
                        <?php
                        $recordBefore = is_string($record['before']) ? json_decode($record['before']) : $record['before'];
                        $recordAfter = is_string($record['after']) ? json_decode($record['after']) : $record['after'];
                        ?>
                    @endif
                    @if ($record['after'] != $record['before'] && $recordBefore != $recordAfter)
                        <tr>
                            @if ($count == 0)
                            <td class="align-middle" rowspan="{{ $num }}">{{ $jobOfferHistory->created_at }}</td>
                            <td class="align-middle" rowspan="{{ $num }}">{{ $jobOfferHistory->user->name }}</td>
                            @endif
                            
                            @if ($key == 'customerId')
                            <td>顧客名</td>
                            @else
                            <td>{{ config('items')[$key] }}</td>
                            @endif

                            @if (($key == 'customerId'))
                            <td>{{ $customers[$record['before']] }}</td>
                            <td>{{ $customers[$record['after']] }}</td>
                            @elseif ($key == 'user_id')
                            <td>{{ $users[$record['before']] }}</td>
                            <td>{{ $users[$record['after']] }}</td>
                            @elseif ($key == 'holiday')
                            <?php
                                $holidayBefore = '';
                                $holidayAfter = '';

                                foreach ($recordBefore as $index => $dayOfWeek) {
                                    if ($index != 0) {
                                        $holidayBefore .= ', ';
                                    }
                                    $holidayBefore .= config('options')['holiday'][$dayOfWeek];
                                }
                                foreach ($recordAfter as $index => $dayOfWeek) {
                                    if ($index != 0) {
                                        $holidayAfter .= ', ';
                                    }
                                    $holidayAfter .= config('options')['holiday'][$dayOfWeek];
                                }
                            ?>
                            <td>{{ $holidayBefore }}</td>
                            <td>{{ $holidayAfter }}</td>
                            @elseif ($key == 'long_vacation')
                            <?php
                                $longVacationBefore = '';
                                $longVacationAfter = '';

                                if (!is_null($recordBefore)) {
                                    foreach ($recordBefore as $index => $whatDay) {
                                        if ($index != 0) {
                                            $longVacationBefore .= ', ';
                                        }
                                        $longVacationBefore .= config('options')['long_vacation'][$whatDay];
                                    }
                                }
                                if (!is_null($recordAfter) ) {
                                    foreach ($recordAfter as $index => $whatDay) {
                                        if ($index != 0) {
                                            $longVacationAfter .= ', ';
                                        }
                                        $longVacationAfter .= config('options')['long_vacation'][$whatDay];
                                    }
                                }
                            ?>
                            <td>{{ $longVacationBefore }}</td>
                            <td>{{ $longVacationAfter }}</td>
                            @elseif ($key == 'status')
                            <td>{{ $record['before'] ? config('options')['status_edit'][intval($record['before'])] : '' }}</td>
                            <td>{{ $record['after'] ? config('options')['status_edit'][intval($record['after'])] : '' }}</td>
                            @elseif ($key == 'billing_unit_1' || $key == 'billing_unit_2' || $key == 'billing_unit_3'|| $key == 'payment_unit_1')
                            <td>{{ $record['before'] ? config('options')['salary_term'][intval($record['before'])] : '' }}</td>
                            <td>{{ $record['after'] ? config('options')['salary_term'][intval($record['after'])] : '' }}</td>
                            @elseif ($key == 'qualification' || $key == 'experience')
                            <td>{{ $record['before'] ? config('options')['requirement'][intval($record['before'])] : '' }}</td>
                            <td>{{ $record['after'] ? config('options')['requirement'][intval($record['after'])] : '' }}</td>      
                            @else
                            <td>{{ array_key_exists($key, config('options')) && !empty($record['before']) ? config('options')[$key][intval($record['before'])] : $record['before'] }}</td>
                            <td>{{ array_key_exists($key, config('options')) && !empty($record['after']) ? config('options')[$key][intval($record['after'])] : $record['after'] }}</td>
                            @endif
                        </tr>
                        <?php $count++ ?>
                    @endif
                @endforeach
            @endforeach
        </table>
        @else
        <div>
            この求人情報に編集履歴はありません。
        </div>
        @endif

    </div>

    <div class="d-flex  justify-content-center mt-3">
        <a href="{{ route('job_offers.index') }}">
            <button class="btn btn-outline-secondary btn-lg"type="button">
                求人情報一覧に戻る
            </button>
        </a>
    </div>

</div>

@endsection
