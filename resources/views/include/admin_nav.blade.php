 <ul class="navigation-menu">
          <li class="nav-category-divider" style="background: #e9ecef;">MAIN</li>

          <li>
            <a href="{{route('accredIndex')}}">
              <span class="link-title">Dashboard</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
          <li>
            <a href="#sample-pages" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Accreditation</span>
              <i class="mdi mdi-library link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="sample-pages">
              <li>
                <a href="{{route('adminAcred_prog')}} ">Accredited Programs</a>
              </li>
              <li>
                <a href="{{route('accred_status')}}">Accreditation Status</a>
              </li>
            </ul>
          </li>

          <li>
            <a href="#school" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Schools</span>
              <i class="mdi mdi-school link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="school">
              <li>
                <a href="{{ route('viewSchool')}} ">Schools</a>
              </li>
              <li>
                <a href="{{ route('academic_programs')}}">Academic Program</a>
              </li>
            </ul>
          </li>

          <li>
            <a href="#students" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Students</span>
              <i class="mdi mdi-folder-account link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="students">
              <li>
                <a href="{{ route('viewStudentAward')}} ">Award</a>
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
          <li class="nav-category-divider" style="background: #e9ecef;">-----</li>
          <li>
          <li>
            <a href="{{route('instAward')}}">
            <span class="link-title">Institutional Awards <br>& Recognition</span>
              <i class="mdi mdi-trophy link-icon"></i>
            </a>
          </li>
          <li>
            <a href="{{route('partners')}}">
              <span class="link-title">Partners</span>
              <i class="mdi mdi-account-multiple link-icon"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <span class="link-title">Licensure Examination</span>
              <i class="mdi mdi-book link-icon"></i>
            </a>
          </li>
          <li class="nav-category-divider" style="background: #e9ecef;">Report</li>
          <li>
            <a href="#rp" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Reports</span>
              <i class="mdi mdi-table link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="rp">
              <li>
                <a href="{{ route('accredReport')}} ">Accreditation Reports</a>
              </li>
              <li>
                <a href="{{ route('viewProgramHistory')}}">Accreditation History Reports</a>
              </li>
            </ul>
          </li>
        </ul>