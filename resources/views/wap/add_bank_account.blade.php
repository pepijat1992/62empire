@extends('wap.layouts.master')

@section('content')
<div class="features-home segments-page">
    <div class="container-pd item-list">
        <div class="section-title mt-2 text-center">
            <h2 class="text-center mt-3">{{__('words.add_bank_account')}}</h2>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="content b-shadow p-4">
                    <form action="{{route('wap.bank_account.create')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">{{__('words.bank')}} <span class="text-danger">*</span></label>
                            <select name="bank" class="form-control" required>
                                @foreach ($banks as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.account_name')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="account_name" required placeholder="{{__('words.account_name')}}" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.account_no')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="account_no" required placeholder="{{__('words.account_no')}}" />
                        </div>
                        <button type="submit" name="page" value="withdraw" class="btn btn-primary btn-block mt-4">{{__('words.next')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            
        });
    </script>
@endsection
