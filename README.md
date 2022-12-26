# B2Broker Test
This is simplified version without tests, logs and some business logic simplification.
The system does not use a separate balance field to calculate the balance. Instead, on the database side, we summarize all user transactions for certain dates. This allows us to determine the user's balance for any date.
Like this:  sum(if(tr.type = 'debit', tr.amount, -tr.amount))

I used the following patterns:
- Specification - simplification of conditions
- Repository - as a data layer
- CQRS - for segregation reading and writting business logic
- DTO - for grouping sets of fields for business logic

PHPCs PSR-12
PHPStan Level 9