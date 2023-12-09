@section('script-resource')
<script src="{{asset('assets/admin/js/jquery.validate.min.js')}}"></script>
<script>
    $(document).ready(function(){
        setTimeout(makeChecked,1000)
        // this.makeChecked();
    })

    function getDesignationForRole(value) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var department_id = value;
        $.ajax({
            url: "/admin/get_designation_for_role",
            type: "POST",
            data: {
                department_id: department_id,
            },
            success: function(data) {
                if (data) {
                    $('.designation_id').html(data);
                }
            }
        });
    }

    function makeChecked(){
                groups = document.querySelectorAll('.group');
                groups.forEach(group => {
                    let groupHead = group.querySelector('.group-head');
                    let accessCheckboxes = group.querySelectorAll('ul li input').length;
                    let checkedAccessCheckBoxes = group.querySelectorAll('ul li input:checked').length;
                    console.log("ami grouphead peyechi",groupHead,accessCheckboxes,checkedAccessCheckBoxes)
                    if(accessCheckboxes == checkedAccessCheckBoxes){
                        groupHead.checked = true;
                    } else {
                        console.log("condition false")
                        groupHead.checked = false;
                    }
                })

                let selectAllCheckbox = document.querySelector('#selectAll');
                let totalAccessCheckboxes = document.querySelectorAll('.access').length;
                let totalCheckedAccessCheckBoxes = document.querySelectorAll('.access:checked').length;
                console.log("ami length peyechi",totalAccessCheckboxes,totalCheckedAccessCheckBoxes)

                if(totalAccessCheckboxes == totalCheckedAccessCheckBoxes){
                    selectAllCheckbox.checked = true;
                } else {
                    selectAllCheckbox.checked = false;
                }
            }
            async function onClickGroupHeads() {
                let access = document.querySelectorAll('.access')
                let groupHead = event.target;
                let ul = groupHead.parentNode.querySelector('ul');
                let accessCheckboxes = ul.querySelectorAll('li input');

                if(groupHead.checked){
                    accessCheckboxes.forEach(checkbox => {
                        $(checkbox).prop("checked",true);
                    })
                } else {
                    accessCheckboxes.forEach(checkbox => {
                        $(checkbox).prop("checked",false);
                    })
                }
                this.makeChecked();
            }
            async function checkAll(){
                let access = $("#selectAll").prop("checked");
                console.log("check access",access)
                access == true ? $('.access').prop("checked",true) : $('.access').prop("checked",false)
                this.makeChecked();
            }
</script>
@include('vendor.sweetalert2.sweetalert2_js')
@endsection
