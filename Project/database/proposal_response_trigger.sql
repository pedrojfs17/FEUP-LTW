DROP TRIGGER IF EXISTS beforeDecideProposal;
DROP TRIGGER IF EXISTS onProposalApproved;
DROP TRIGGER IF EXISTS onProposalComplete;
DROP TRIGGER IF EXISTS onProposalRejectedOrWithdrawn;
DROP TRIGGER IF EXISTS onAddProposalRejectIfAdopted;
DROP TRIGGER IF EXISTS onAddProposalRejectIfPending;

CREATE TRIGGER beforeDecideProposal
BEFORE UPDATE ON pet_proposal
WHEN New.decision!=Old.decision AND New.decision = 1 AND (New.pet_id IN (SELECT pet_id FROM pet WHERE pet_state=3 OR pet_state=4))
BEGIN
    SELECT RAISE(ROLLBACK, 'Cannot accept proposal for pet that has been adopted');
END;


CREATE TRIGGER onProposalApproved
AFTER UPDATE ON pet_proposal
WHEN New.decision!=Old.decision AND New.decision = 1 AND NOT (New.pet_id IN (SELECT pet_id FROM pet WHERE pet_state=3 OR pet_state=4))
BEGIN
    UPDATE pet SET pet_state = 3 WHERE pet.pet_id = New.pet_id;
    UPDATE pet_proposal SET decision = -1 WHERE pet_proposal.pet_id = New.pet_id AND pet_proposal.pet_proposal_id <> New.pet_proposal_id AND pet_proposal.decision = 0;
END;

CREATE TRIGGER onProposalComplete
AFTER UPDATE ON pet_proposal
WHEN New.decision!=Old.decision AND (New.decision = 2)
BEGIN
    UPDATE pet SET pet_state = 4, username=New.username WHERE pet.pet_id = New.pet_id;
END;

CREATE TRIGGER onProposalRejectedOrWithdrawn
AFTER UPDATE ON pet_proposal
WHEN (Old.decision = 1 AND (New.decision = -1 OR New.decision = -2))
BEGIN
    UPDATE pet SET pet_state = 2 WHERE pet.pet_id = New.pet_id;
END;


CREATE TRIGGER onAddProposalRejectIfAdopted
BEFORE INSERT ON pet_proposal
WHEN (New.pet_id IN (SELECT pet_id FROM pet WHERE pet_state=3 OR pet_state=4))
BEGIN
    SELECT RAISE(ROLLBACK, 'Cannot make proposal for pet that has been adopted');
END;

CREATE TRIGGER onAddProposalRejectIfPending
BEFORE INSERT ON pet_proposal
WHEN (New.username IN (SELECT username FROM pet_proposal WHERE pet_proposal.username=New.username AND decision=0 AND pet_proposal.pet_id=New.pet_id))
BEGIN
    SELECT RAISE(ROLLBACK, 'Cannot make proposal for pet that has pending proposal');
END;
