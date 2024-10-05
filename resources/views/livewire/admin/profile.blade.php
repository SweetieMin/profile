<div>
    
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
            <div class="pd-20 card-box height-100-p">
                <div class="profile-photo">
                    <a href="javascript:;" onclick="event.preventDefault();document.getElementById('profilePictureFile').click();" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                    <img src="{{ $user->picture }}" alt="" class="avatar-photo" id="profilePicturePreview">
                    <input type="file" name="profilePictureFile" id="profilePictureFile" class="d-none" style="opacity: 0">
                </div>
                <h5 class="text-center h5 mb-0">{{ $user->name }}</h5>
                <p class="text-center text-muted font-14">
                    {{ $user->email }}
                </p>
    
                <div class="profile-social">
                    <h5 class="mb-20 h5 text-blue">Social Links</h5>
                    <ul class="clearfix">
                        <li>
                            <a href="{{ $this->facebook_url }}" target="_blank" class="btn" data-bgcolor="#3b5998" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(59, 89, 152);"><i class="fa fa-facebook"></i></a>
                        </li>
                        
                        <li>
                            <a href="{{ $this->instagram_url }}" target="_blank" class="btn" data-bgcolor="#f46f30" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(244, 111, 48);"><i class="fa fa-instagram"></i></a>
                        </li>

                        <li>
                            <a href="{{ $this->youtube_url }}" target="_blank" class="btn" data-bgcolor="red" data-color="{{ $this->instagram_url }}ffffff" style="color: rgb(255, 255, 255); background-color: rgb(255, 0, 0);"><i class="fa fa-youtube"></i></a>
                        </li>

                        <li>
                            <a href="{{ $this->github_url }}" target="_blank" class="btn" data-bgcolor="black" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(0, 0, 0);"><i class="fa fa-github"></i></a>
                        </li>
                    
                    </ul>
                </div>
    
            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden">
                <div class="profile-tab height-100-p">
                    <div class="tab height-100-p">
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item">
                                <a wire:click="selectTab('personal_details')" class="nav-link {{ $tab === 'personal_details' ? 'active' : '' }}" data-toggle="tab" href="#personal_details" role="tab">Personal details</a>
                            </li>
                            <li class="nav-item">
                                <a wire:click="selectTab('update_password')" class="nav-link {{ $tab === 'update_password' ? 'active' : '' }}" data-toggle="tab" href="#update_password" role="tab">Update password</a>
                            </li>
                            <li class="nav-item">
                                <a wire:click="selectTab('social_links')" class="nav-link {{ $tab === 'social_links' ? 'active' : '' }}" data-toggle="tab" href="#social_links" role="tab">Social links</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- Personal details Tab start -->
                            <div class="tab-pane fade {{ $tab === 'personal_details' ? 'active show' : '' }}" id="personal_details" role="tabpanel">
                                <div class="pd-20">
                                    <form wire:submit="updatePersonalDetails()">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label for="name">Full name</label>
                                                    <input  type="text" class="form-control" wire:model="name" placeholder="Enter full name" id="name" autocomplete="off">
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input  type="email" class="form-control" wire:model="email" placeholder="Enter email address" disabled autocomplete="off" id="email">
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input  type="text" class="form-control" wire:model="username" placeholder="Enter username" id="username" autocomplete="on">
                                                    @error('username')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label for="bio">Bio</label>
                                                    <textarea wire:model="bio"  cols="4" rows="4" class="form-control" placeholder="Type your bio..." id="bio"></textarea>
                                                    @error('bio')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="form-group text-center mt-4">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Personal details Tab End -->
                            <!-- Update password Tab start -->
                            <div class="tab-pane fade {{ $tab === 'update_password' ? 'active show' : '' }}" id="update_password" role="tabpanel">
                                <div class="pd-20 profile-task-wrap">
                                    <form wire:submit="updatePassword()">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="current_password">Current password</label>
                                                    <input type="password" class="form-control" wire:model="current_password" placeholder="Enter current password">
                                                    @error('current_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="new_password">New password</label>
                                                    <input type="password" class="form-control" wire:model="new_password" placeholder="Enter new password">
                                                    @error('new_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="new_password_confirmation">Confirm new password</label>
                                                    <input type="password" class="form-control" wire:model="new_password_confirmation" placeholder="Confirm new password">
                                                    @error('new_password_confirmation')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center mt-2">
                                            <button type="submit" class="btn btn-primary">Update password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Update password Tab End -->
                            <!-- Social links Tab start -->
                            <div class="tab-pane fade {{ $tab === 'social_links' ? 'active show' : '' }}" id="social_links" role="tabpanel">
                                <div class="pd-20 profile-task-wrap">
                                    <form method="POST" wire:submit="updateSocialLinks()" >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="facebook_url"><b>Facebook</b></label>
                                                    <input type="text" class="form-control" wire:model='facebook_url' placeholder="Facebook URL">
                                                    @error('facebook_url')
                                                        <span class="text-danger ml-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="instagram_url"><b>Instagram</b></label>
                                                    <input type="text" class="form-control" wire:model='instagram_url' placeholder="Instagram URL">
                                                    @error('instagram_url')
                                                        <span class="text-danger ml-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="youtube_url"><b>Youtube</b></label>
                                                    <input type="text" class="form-control" wire:model='youtube_url' placeholder="Youtube URL">
                                                    @error('youtube_url')
                                                        <span class="text-danger ml-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="github_url"><b>Github</b></label>
                                                    <input type="text" class="form-control" wire:model='github_url' placeholder="Github URL">
                                                    @error('github_url')
                                                        <span class="text-danger ml-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center mt-2">
                                            <button type="submit" class="btn btn-primary">Update social</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Social links Tab End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
