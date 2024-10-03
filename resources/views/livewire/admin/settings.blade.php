<div>

    <div class="tab">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a wire:click="selectTab('general_settings')" class="nav-link text-blue {{ $tab === 'general_settings' ? "active" : "" }}" data-toggle="tab" href="#general_settings" role="tab" aria-selected="false">General settings</a>
            </li>
            <li class="nav-item">
                <a wire:click="selectTab('logo_favicon')" class="nav-link text-blue {{ $tab === 'logo_favicon' ? "active" : "" }}" data-toggle="tab" href="#logo_favicon" role="tab" aria-selected="true">Logo & Favicon</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade {{ $tab === 'general_settings' ? "active show" : "" }}" id="general_settings" role="tabpanel">
                <div class="pd-20">
                    <form wire:submit='updateSiteInfo()'>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site title</b></label>
                                    <input type="text" class="form-control" wire:model="site_title" placeholder="Enter site title">
                                    @error('site_title')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site email</b></label>
                                    <input type="text" class="form-control" wire:model="site_email" placeholder="Enter site email">
                                    @error('site_email')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site phone</b></label>
                                    <input type="text" class="form-control" wire:model="site_phone" placeholder="Enter site phone">
                                    @error('site_phone')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site Meta Keywords</b> <small> ̣(Optional)</small></label>
                                    <input type="text" class="form-control" wire:model="site_meta_keywords" placeholder="Enter site Meta Keywords">
                                    @error('site_meta_keywords')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for=""><b>Site Meta Description</b> <small> (Optional)</small></label>
                            <textarea class="form-control" cols="4" rows="4" wire:model="site_meta_description" placeholder="Type site meta descriptiom..."></textarea>
                            @error('site_meta_description')
                                <span class="text-danger ml-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group text-center mt-2">
                            <button type="submit" class="btn btn-primary">Update social</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade {{ $tab === 'logo_favicon' ? "active show" : "" }}" id="logo_favicon" role="tabpanel">
                <div class="pd-20">
                    Logo & Favicon
                </div>
            </div>
        </div>
    </div>

</div>
