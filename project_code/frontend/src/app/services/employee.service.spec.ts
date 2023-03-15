import { TestBed } from '@angular/core/testing';
import { Users } from '../models/users';
import {
  HttpClientTestingModule,
  HttpTestingController
} from '@angular/common/http/testing';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { EmployeeService } from './employee.service';

describe('EmployeeService', () => {
  let service: EmployeeService;
  let httptestoControl: HttpTestingController;
  let HttpClient: HttpClient;
  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [HttpClientTestingModule],
      providers: [EmployeeService],
    });
    service = TestBed.inject(EmployeeService);
  });

  beforeEach(() => {
   
    service = TestBed.inject(EmployeeService);
    httptestoControl =TestBed.inject(HttpTestingController);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });

  it('HTTPclient get method', () => {
    const employee: Users[] =[
      {
        "id": 7,
        "name": "amendra rajput",
        "email": "amendrar@gmail.com",
        "domain": "google.com",
        "location": "lko",
        "phone": "8960883558",
        "gender": "male",
        "dob": "1995-06-24"
    },
    {
      "id": 8,
      "name": "amendra rajput",
      "email": "amendrar@gmail.com",
      "domain": "google.com",
      "location": "lko",
      "phone": "8960883558",
      "gender": "male",
      "dob": "1995-06-24"
  }
    ];
    service.getEmployeeList().subscribe((data)=>{
      expect(employee).toBe(data, "should check it mock data.")
    });
    const req = httptestoControl.expectOne(service.apiUrl)
    expect(req.cancelled).toBeFalsy();
    expect(req.request.responseType).toEqual('json');

    req.flush(employee);
    httptestoControl.verify();
  });

  it('should add employee and return added empolyee', () => {
    const employee: Users =
      {
        "id": 12,
        "name": "amendra rajput",
        "email": "amendrar@gmail.com",
        "domain": "google.com",
        "location": "lko",
        "phone": "8960883558",
        "gender": "male",
        "dob": "1995-06-24"
    }
    ;
    service.addEmployee(employee).subscribe((data)=>{
      expect(data).toBe(employee);
    });
    const req = httptestoControl.expectOne(service.apiUrl)
    expect(req.cancelled).toBeFalsy();
    expect(req.request.responseType).toEqual('json');

    req.flush(employee);
    
  });
  
  it('should test 404 error',()=>{
    const errorMsg="mock 404 error occured";
    service.getEmployeeList().subscribe((data)=>{
      fail('failing with error 404');
    },
    (error: HttpErrorResponse)=>{
      expect(error.status).toEqual(404);
      expect(error.error).toEqual(errorMsg);
    }
    );
  })

});
