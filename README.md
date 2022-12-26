# B2Broker Test
This is simplified version without tests, logs and some business logic simplification (like no fixed fee for Ppayment methods).
This payment system operates integer type for amounts (1000000 * REAL_AMOUNT). This allows you to avoid problems with floating point numbers on the one hand and work with amounts as a primitive.
The system does not use a separate balance field to calculate the balance. Instead, on the database side, we summarize all user transactions for certain dates. This allows us to determine the user's balance for any date.
Like this:  sum(if(tr.type = 'debit', tr.amount, -tr.amount))

I used the following patterns:
- Specification - simplification of conditions
- Repository - as a data layer
- CQRS - for segregation reading and writtind business logic
- DTO - for grouping sets of fields for business logic

PHPCs PSR-12