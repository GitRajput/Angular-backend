import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Users } from '../models/users';

@Injectable({
  providedIn: 'root',
})
export class EmployeeService {
  public apiUrl="http://localhost/backendapi/users";
  constructor(private _http: HttpClient) {}

  addEmployee(data: Users): Observable<Users>{
    return this._http.post<Users>(this.apiUrl, data);
  }

  updateEmployee(id: number, data: Users): Observable<Users> {
    return this._http.put<Users>(this.apiUrl+`/${id}`, data);
  }

  getEmployeeList(): Observable<Users[]> {
    return this._http.get<Users[]>(this.apiUrl);
  }

  deleteEmployee(id: number): Observable<any> {
    return this._http.delete(this.apiUrl+`/${id}`);
  }
}
