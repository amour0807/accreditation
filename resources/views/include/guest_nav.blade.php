<ul class="navigation-menu">
          <li class="nav-category-divider" style="background: #e9ecef;">MAIN</li>

          <li>
            <a href="{{route('userAccredIndex')}}">
              <span class="link-title">Dashboard</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
           <li>
            <a href="{{route('acred_prog')}}">
              <span class="link-title">Accreditation</span>
              <i class="mdi mdi-library link-icon"></i>
            </a>
          </li>

          <li>
            <a href="#students" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Students</span>
              <i class="mdi mdi-folder-account link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="students">
              <li>
                <a href="{{ route('userStudentAward')}} ">Award</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#teaching" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Teaching</span>
              <i class="mdi mdi-bulletin-board link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="teaching">
              <li>
                
              </li>
            </ul>
          </li>
          <li>
            <a href="#nt" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Non Teaching</span>
              <i class="mdi mdi-clipboard link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="nt">
              <li>
               
              </li>
            </ul>
          </li>
          
          <li class="nav-category-divider" style="background: #e9ecef;">Report</li>
          <li>
            <a href="#rp" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Reports</span>
              <i class="mdi mdi-table link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="rp">
              <li>
                <a href="{{ route('userAccredReport')}} ">Accreditation Reports</a>
              </li>
              <li>
                <a href="{{ route('userViewProgramHistory')}}">Accreditation History Reports</a>
              </li>
            </ul>
          </li>
        </ul>