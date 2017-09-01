<div style="text-align: center; margin-top: 50px;">
    <button class="btn btn-danger" onclick="$('#rewardDialog').modal('show');">&nbsp;&nbsp;&nbsp;&nbsp;打赏&nbsp;&nbsp;&nbsp;&nbsp;</button>
</div>

<div role="dialog" tabindex="-1" id="rewardDialog" class="bootbox modal fade in" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div style="text-align: center;">
                    <img src="{{ publicPath() }}img/logo.png" width="100px" />
                    <p>感谢你的支持，我会继续努力！</p>
                </div>

                <div class="row" style="text-align: center;">
                    <div class="col-xs-6"><img src="{{ publicPath() }}img/we.jpg" width="100%" /></div>
                    <div class="col-xs-6"><img src="{{ publicPath() }}img/ali.jpg" width="100%" /></div>
                    <div class="col-xs-12">
                        <button class="btn btn-default" type="button" data-dismiss="modal">&nbsp;&nbsp;&nbsp;&nbsp;关闭&nbsp;&nbsp;&nbsp;&nbsp;</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
