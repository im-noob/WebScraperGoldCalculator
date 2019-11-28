@extends('layouts.app')

@section('content')
      
    <div class="mb-4">
        <div class="form-group">
            <label for="USDvalue">Enter USD</label>
            <input type="text" class="form-control" id="USDvalue" placeholder="USD">
        </div>
    
        <div class="form-group">
            <label for="USDtoINRConverted">Current(live) INR value based on USD entred</label>
            <input type="text" class="form-control" value="0" id="USDtoINRConverted" readonly>
        </div>
    
        <div class="form-group">
            <label for="GoldQuientityIngForINR">Gold Quntity(in grams) based on USD entred</label>
            <input type="text" class="form-control" value="0" id="GoldQuientityIngForINR" readonly>
        </div>
        
        <button type="button" id="calculate" class="btn btn-success">Calculate</button>
    </div>

    <form id="sendNotiSection" method="POST" action="{{url('/sendMessageToUser')}}">

        @csrf

        <div class="form-group">
            <label class="col-mt-4" for="selectMultiEMP">Select Multiple Employee to send Live Rate</label>
            <select multiple class="form-control" id="selectMultiEMP" name="selectMultiEMP[]" size="5" required>
                @forelse ($data as $item)
                    <option value="{{$item->phone}}">{{$item->first_name}} {{$item->last_name}} - {{$item->phone}}</option>   
                @empty
                    <option value="">No Item</option>
                @endforelse
                
            </select>
        </div>
        <input type="hidden" value="" id="INRvalueIN1USD"/>
        <input type="hidden" value="" id="INRto1gGold"/>

    
        <button type="submit" id="sendNoti" class="btn btn-danger">Send Notification</button>
        

    </form>

    <script>
            $(function(){
                // hinding button
                $("#sendNotiSection").hide();
                $("#calculate").click(function(){
                    $USDvalue = $("#USDvalue").val();
                    
                    if ($USDvalue.length == 0) {
                        alert("USD Value Required");
                        $("#USDvalue").focus();
                        return;
                    }
                    // hinding button
                    $("#sendNotiSection").hide();
                    //Didabling Button 
                    $("#calculate").attr('disabled','disabled');

                    // START: Ajax Request
                    $.ajax({
                            cache: false,
                            type: "POST",
                            data: {
            
                                _token:  "{{ csrf_token() }}",
                                USDvalue : $USDvalue,
                            },
                            url: "{{url('/')}}/getGoldandUSD", 
                            success: function(response){
                                console.log(response)
                                if (response.received) {

                                    // showing button
                                    $("#sendNotiSection").show();
                                    //Didabling Button 
                                    $("#calculate").removeAttr('disabled');

                                    //filling value
                                    $("#USDtoINRConverted").val(response.data.USDtoINRConverted);
                                    $("#GoldQuientityIngForINR").val(response.data.GoldQuientityIngForINR);
                                    $("#INRvalueIN1USD").val(response.data.INRvalueIN1USD);
                                    $("#INRto1gGold").val(response.data.INRto1gGold);

                                }else{
                                    alert("Oops!!! Somthing is not right");
                                }
                            },
                            error: function(xhr,status,error){
                                console.log(xhr.responseJSON);
                                console.log(status);
                                console.log(error);
                            }
                    });
                    // END: Ajax Request

                })
            });
    </script>
@endsection
