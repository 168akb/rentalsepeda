    <!-- Modal Complete Data -->
<div class="modal fade" role="dialog" id="completedata">
    <div class="modal-dialog modal-large modal-dialog-centered">
        <div class="modal-content" style="border-radius: 10px">
            <div class="modal-header">
            </div>

            <div class="modal-body">
                <h2>Wah, Data kamu belum lengkap!</h2>
                <p>Silahkan upload KTP anda terlebih dahulu untuk dapat melakukan transaksi</p>
            </div>

            <div class="modal-footer">
                <a href="{{route('profile.index')}}"><button type="button" class="btn btn-default">Oke</button></a>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Complete Data -->


@push('script')
<script>
    @if(empty(Auth::user()->foto_ktp) && Auth::user()->level_id == 3)
    $(window).on('load', function() {
        $('#completedata').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    @endif
</script>
@endpush