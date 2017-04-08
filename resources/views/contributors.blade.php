<?php
use App\User;
use App\Project_and_contributors;
use App\Category;
use App\Project;
?>
@extends('layouts.app')

@section('settings_contributors')
<nav class="navbar">
    <div class="container">
        <ul class="nav navbar-nav">
            <li><a href="{{url('show/settings'). '/' . $id}}" style="padding: 7px;">Settings</a></li>
            <li><a href="#" class="nav-link active" style="background: #337ab7; color: white; padding: 7px;">Contributors</a></li>
        </ul>
    </div>
</nav>
@endsection


@section('content')

    
    
    <div class="col-sm-9 col-sm-offset-2">
    <div id="manageContributors" class="scripted" style="display: block;">
        <h3> Contributors
            <!-- ko if: canEdit -->
                <!-- <a href="" data-toggle="modal" class="btn btn-success btn-sm m-l-md">
                  <i class="fa fa-plus"></i> Add
                </a>
 -->    <button type="button" class="btn btn-success btn-sm m-l-md" data-toggle="modal" data-target="#myModal">
            <span class="glyphicon glyphicon-plus"></span> Add
        </button>
            <!-- /ko -->
        </h3>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Add Contributors</b></h4>
              </div>
              <!-- MODAL BODY MODAL BODY -->

              <div class="modal-body">

                <!-- Whom to add -->
                <div data-bind="if: page() == 'whom'">

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <div class="navbar-form" role="search" id="target">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name" name="search_name" id="search_name">
                                <span class="input-group-btn">
                                    <div class="btn btn-default" id="submitContactBtn">
                                        <span class="glyphicon glyphicon-search">
                                            <span class="sr-only">Search</span>
                                        </span>
                                    </div>
                                </span>
                            </div>
                        </div>        

<!--                         <div id="showResult" class="showResult">

                        </div>

 -->                        
    
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#submitContactBtn').click(function(){ 
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });


                                    $.post('http://localhost/project/public/AjaxPage', {

                                        search_name: $('#search_name').val()

                                    },  function(response){  
                                            var output = "";
                                            for (var i = 0; i < response.length; i+=3) {
                                                output = output + '<tr><td><button type="button" class="btn btn-success btn-sm m-l-md col-sm-3"><span class="glyphicon glyphicon-plus" id="add"></span></button><div class="col-sm-9"><a href="../../profile/' + response[i] + '">' + response[i+1] + '</a><p>' + response[i+2] + '</p></div></td></tr>';
                                            }
                                            $('#showResult').html(output);
                                        }


                                    );
                                });
                                   
                            });
                        </script>
                    </div>


                    
                    <!-- Choose which to add -->
                    <div class="row">
                        <!-- <div class="alert alert-success">
                            <strong>Your Result!</strong> <span value="" name="showSearchTerm" id="showSearchTerm"></span>
                        </div> -->
                       
                        <div class="col-md-6">
                            <div>
                                <span class="modal-subheader">Results</span>
                                
                                <table class="table-condensed">
                                <thead data-bind="visible: selection().length" style="display: none;">
                                    <tr><th width="10%"></th>
                                    <th width="15%"></th>
                                    <th>Name</th>
                                    <th>
                                        Permissions
                                        <i class="fa fa-question-circle permission-info" data-toggle="popover" data-title="Permission Information" data-container="#addContributors" data-html="true" data-content="<dl><dt>Read</dt><dd><ul><li>View project content and comment</li></ul></dd><dt>Read + Write</dt><dd><ul><li>Read privileges</li> <li>Add and configure components</li> <li>Add and edit content</li></ul></dd><dt>Administrator</dt><dd><ul><li>Read and write privileges</li><li>Manage contributor</li><li>Delete and register project</li><li>Public-private settings</li></ul></dd></dl>" data-original-title="" title=""></i>
                                    </th>
                                </tr></thead>
                                <tbody id="showResult"></tbody>
                                </table>

                                <a data-bind="visible: addAllVisible, click:addAll" style="display: none;">Add all</a>
                            </div>

                           
                          
                        </div><!-- ./col-md -->

                        <div class="col-md-6">
                            <div>
                                <span class="modal-subheader">Adding</span>
                                <a data-bind="visible: removeAllVisible, click:removeAll" style="display: none;">Remove all</a>
                            </div>

                            <!-- TODO: Duplication here: Put this in a KO template -->
                            <table class="table-condensed">
                                <thead data-bind="visible: selection().length" style="display: none;">
                                    <tr><th width="10%"></th>
                                    <th width="15%"></th>
                                    <th>Name</th>
                                    <th>
                                        Permissions
                                        <i class="fa fa-question-circle permission-info" data-toggle="popover" data-title="Permission Information" data-container="#addContributors" data-html="true" data-content="<dl><dt>Read</dt><dd><ul><li>View project content and comment</li></ul></dd><dt>Read + Write</dt><dd><ul><li>Read privileges</li> <li>Add and configure components</li> <li>Add and edit content</li></ul></dd><dt>Administrator</dt><dd><ul><li>Read and write privileges</li><li>Manage contributor</li><li>Delete and register project</li><li>Public-private settings</li></ul></dd></dl>" data-original-title="" title=""></i>
                                    </th>
                                </tr></thead>
                                <tbody data-bind="foreach:{data:selection, as: 'contributor', afterRender:makeAfterRender()}"></tbody>
                            </table>
                        </div>

                    </div>

                </div>
                <!-- Component selection page -->
                <div data-bind="visible:page()=='which'" style="display: none;">

                    <div>
                        Adding contributor(s)
                        <span data-bind="text:addingSummary()"></span>
                        to <span data-bind="text:title">Test project</span>.
                    </div>

                    <hr>

                    <div style="margin-bottom:10px;">
                        You can also add the contributor(s) to any components on which you are an admin.
                    </div>

                    <div>
                        Select:&nbsp;
                        <a class="text-bigger" data-bind="click:selectAllNodes">Select all</a>
                        &nbsp;|&nbsp;
                        <a class="text-bigger" data-bind="click:selectNoNodes">Select none</a>
                    </div>
                    <div class="tb-row-titles">
                        <div style="width: 100%" data-tb-th-col="0" class="tb-th">
                            <span class="m-r-sm"></span>
                        </div>
                    </div>
                    <div class="osf-treebeard">
                        <div id="addContributorsTreebeard"><div style="overflow-x: auto" class="gridWrapper"><div style="width:auto;" class="tb-table"><div id="tb-tbody"><div style="height: 84.25714285714287px;" class="tb-tbody-inner"><div style="margin-top:0px;"><div class="tb-row  tb-even" data-id="1" data-level="1" data-index="0" data-rindex="0" style="height: 35px;"><div class="tb-td tb-col-0" style="width:4%"><input type="checkbox"></div><div data-id="1" class="tb-td td-title tb-col-1" style="padding-left: 0px; width:96%"><span class="tb-td-first"><span class="tb-toggle-icon"></span><span class="tb-expand-icon-holder"><span class="fa fa-bar-chart po-icon"></span></span></span><span class="title-text"><span>Test project</span></span></div></div></div></div></div></div></div></div>
                    </div>

                </div><!-- end component selection page -->

                <!-- Invite user page -->
                <div data-bind="if:page() === &quot;invite&quot;"></div><!-- end invite user page -->

            </div>

            <!-- END MODAL BODY MODAL BODY  -->
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        
      
    <div>
        <table id="manageContributorsTable" class="table responsive-table responsive-table-xxs">
            <thead>
                <tr>
                    <th class="responsive-table-hide sortable" data-bind="css: {sortable: ($data === 'contrib' &amp;&amp; $root.isSortable())}">Name
                    </th>
                    <th></th>
                   
                    <th class="remove"></th>
                </tr>
            </thead>
            <!-- ko if: $data == 'contrib' -->
            <tbody id="contributors"  class="ko_container ui-sortable">
                <tr class="contrib">
                <td >
                    <!-- ko if: ($parent === 'contrib' && $root.isSortable()) -->
                        <span class="fa fa-bars sortable-bars"></span>
                      
                    <span class="fa toggle-icon fa-angle-down"></span>
                    <div class="card-header">
                        <span data-bind="ifnot: profileUrl"></span>
                        <span data-bind="if: profileUrl">
                            <?php
                                $user_id = Project::where('id', $id)->first()->user_id;
                            ?>
                            <i><b><a class="name-search" href="/83akk/">{{ User::where('id', $user_id)->first()->fullName }}
                            </a></b></i>
                        </span>
                      
                    </div>
                </td>
            
              
                </tr>
               
                @foreach ($contributors as $contributor) 
                <tr class="contrib">
                <td >
                    <!-- ko if: ($parent === 'contrib' && $root.isSortable()) -->
                        <span class="fa fa-bars sortable-bars"></span>
                      
                    <span class="fa toggle-icon fa-angle-down"></span>
                    <div class="card-header">
                        <span data-bind="ifnot: profileUrl"></span>
                        <span data-bind="if: profileUrl">
                            <a class="name-search" href="/83akk/">{{ $contributor }}</a>
                        </span>
                      
                    </div>
                </td>
            
                <td>
                    <div class="td-content" data-bind="visible: !$root.collapsed() || contributor.expanded()">
                        <!-- ko if: (contributor.canEdit() || canRemove) -->
                                <form action="{{url('allow'). '/' . $id}}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <?php 
                                        $email = User::where('fullName', $contributor)->first()->email;
                                    ?>
                                    
                                    <input type="hidden" value="{{$email}}" name="email">
                                                                    
                                    
                                    <button type="submit" class="btn btn-danger btn-sm m l-md" data-toggle="modal">
                                            Remove
                                    </button>
                                  
                                </form>
                        <!-- /ko -->
                    </div>
                </td>
                </tr>
                
                @endforeach
            </tbody>
        </table>
    </div>
    
@endsection
