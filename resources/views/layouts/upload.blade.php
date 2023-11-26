        <!-- Modal Complete Data -->
<div class="modal fade" role="dialog" id="completedata">
    <div class="modal-dialog modal-default modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            </div>

            <div class="modal-body">
                <h2>Transfer Pembayaran</h2>
                <p>Transfer ke No. Rekening 00832932893283 dengan jumlah nominal.</p>
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Complete Data -->


@push('script')
<script>
    $(window).on('load', function() {
        $('#completedata').modal({
            keyboard: false
        });
    });

</script>
@endpush