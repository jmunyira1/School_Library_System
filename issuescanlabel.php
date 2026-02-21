<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Quick Example</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

                <div class="card-body">
                 
                  <div class="form-group">
                    <label for="exampleInputPassword1">Issue to : </label>
                    <input type="number" id="input" name="possesor" class="form-control" id="exampleInputPassword1" placeholder="Enter Admission or StaffID" <?php if($input==1){echo "autofocus";}?>>
                  </div>
 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="status" value="issue" class="btn btn-primary">Issue</button>
                </div>
      
            </div>