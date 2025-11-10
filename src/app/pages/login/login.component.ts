import { Component, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';

function getTenantFromHost(host: string): string | null {
  const parts = host.split('.');
  return parts.length >= 3 ? parts[0] : null;
}

@Component({
  standalone: true,
  selector: 'app-login',
  imports: [CommonModule, ReactiveFormsModule],
  template: `
  <div class="container">
    <h1>Login {{ tenant() ? '(' + tenant() + ')' : '' }}</h1>
    <form [formGroup]="form" (ngSubmit)="submit()">
      <input formControlName="email" placeholder="Email" type="email">
      <input formControlName="password" placeholder="Password" type="password">
      <button type="submit" [disabled]="form.invalid || loading()">Login</button>
    </form>
    <p *ngIf="error()">{{ error() }}</p>
  </div>
  `
})
export class LoginComponent {
  tenant = signal<string | null>(getTenantFromHost(window.location.host));
  loading = signal(false);
  error = signal<string | null>(null);

  form = this.fb.group({
    email: ['', [Validators.required, Validators.email]],
    password: ['', Validators.required],
  });

  constructor(private fb: FormBuilder, private http: HttpClient) {}

  submit() {
    if (this.form.invalid) return;
    this.loading.set(true);
    const payload = { ...this.form.value, tenant: this.tenant() };
    this.http.post('/api/auth/login', payload).subscribe({
      next: () => { this.loading.set(false); window.location.href = '/'; },
      error: (e) => { this.loading.set(false); this.error.set(e?.error?.message ?? 'Login failed'); }
    });
  }
}
