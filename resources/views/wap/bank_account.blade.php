@extends('wap.layouts.master')
@section('content')
    <div class="features-home segments-page">
        <div class="container-pd item-list mb-5">
            <div class="section-title mt-4">
                <h2 class="text-center">{{__('words.bank_account')}}</h2>
            </div>
            <div class="row">
                <div class="container">               
                    <div class="content b-shadow p-3 pb-5">
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addModal" id="btn-add">{{__('words.add_bank_account')}}</button>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('words.bank_name')}}</th>
                                        <th>{{__('words.account_name')}}</th>
                                        <th>{{__('words.account_no')}}</th>
                                        <th>{{__('words.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)                                        
                                        <tr>
                                            <td class="bank" data-id="{{$item->bank_id}}">@if($item->bank){{$item->bank->name}}@endif</td>
                                            <td class="account_name">{{$item->account_name}}</td>
                                            <td class="account_no">{{$item->account_no}}</td>
                                            <td class="py-2">
                                                <a href="javascript:;" data-id="{{$item->id}}" class="btn-edit btn-table"><i class="fa fa-edit"></i></a>
                                                <a href="{{route('wap.bank_account.delete', $item->id)}}" class="btn-edit btn-table btn-confirm"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">{{__('words.add_bank_account')}}</h5>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form method="POST" action="{{route('wap.bank_account.create')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.bank')}}</label>
                            <select name="bank" class="form-control" required>
                                <option value="" hidden>{{__('words.select_bank')}}</option>
                                @foreach ($banks as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.account_name')}}</label>
                            <input type="text" class="form-control" name="account_name" placeholder="{{__('words.account_name')}}" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.account_no')}}</label>
                            <input type="text" class="form-control" name="account_no" placeholder="{{__('words.account_no')}}" required>
                        </div>
                    </div>   
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">{{__('words.edit_bank_account')}}</h5>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form method="POST" action="{{route('wap.bank_account.edit')}}" id="edit_form">
                    @csrf
                    <input type="hidden" name="id" class="id" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.bank')}}</label>
                            <select name="bank" class="form-control bank" required>
                                <option value="" hidden>{{__('words.select_bank')}}</option>
                                @foreach ($banks as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.account_name')}}</label>
                            <input type="text" class="form-control account_name" name="account_name" placeholder="{{__('words.account_name')}}" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.account_no')}}</label>
                            <input type="text" class="form-control account_no" name="account_no" placeholder="{{__('words.account_no')}}" required>
                        </div>
                    </div>   
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit" onclick="show_loading()"><i class="fa fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $(".btn-edit").click(function(){
                let id = $(this).data("id");
                let bank = $(this).parents('tr').find(".bank").data('id');
                let account_name = $(this).parents('tr').find(".account_name").text().trim();
                let account_no = $(this).parents('tr').find(".account_no").text().trim();
                $("#edit_form input.form-control").val('');
                $("#edit_form .id").val(id);
                $("#edit_form .bank").val(bank).change();
                $("#edit_form .account_name").val(account_name);
                $("#edit_form .account_no").val(account_no);
                $("#editModal").modal();
            });
        });
    </script>
@endsection
